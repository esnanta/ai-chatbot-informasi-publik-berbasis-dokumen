import os
import json
import nltk
import uvicorn
import numpy as np
import torch  # Import torch

from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from sentence_transformers import SentenceTransformer
from sklearn.metrics.pairwise import cosine_similarity
from nltk.tokenize import sent_tokenize
import time  # Untuk mengukur waktu loading

# --- Pastikan nltk tokenizer tersedia ---
try:
    nltk.data.find("tokenizers/punkt")
except LookupError:
    nltk.download("punkt")

try:
    nltk.data.find("tokenizers/punkt_tab")
except LookupError:
    nltk.download("punkt_tab")

# --- Inisialisasi FastAPI ---
app = FastAPI()

# --- Konfigurasi CORS ---
origins = ["http://localhost", "http://localhost:80", "*"]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["POST"],
    allow_headers=["Content-Type"],
)

# --- Variabel Global untuk Model dan Data ---
BASE_DIR = "api/knowledge_base"
EMBEDDINGS_FILE = os.path.join(BASE_DIR, "embeddings.npy")
CHUNKS_FILE = os.path.join(BASE_DIR, "chunks.json")

embeddings = None
all_chunks = None
model = None  # Model diinisialisasi sebagai None untuk lazy loading


# --- Fungsi Memuat Data ---
def load_data():
    global embeddings, all_chunks

    try:
        start_time = time.time()
        embeddings = np.load(EMBEDDINGS_FILE)
        end_time = time.time()
        print(f"Embeddings loaded successfully in {end_time - start_time:.2f} seconds.")
    except FileNotFoundError:
        print(f"Error: Embeddings file not found at {EMBEDDINGS_FILE}")
        raise  # Re-raise exception to stop the application
    except Exception as e:
        print(f"Error loading embeddings: {e}")
        embeddings = None

    try:
        start_time = time.time()
        with open(CHUNKS_FILE, "r", encoding="utf-8") as f:
            all_chunks = json.load(f)
        end_time = time.time()
        print(f"Chunks loaded successfully in {end_time - start_time:.2f} seconds.")
    except FileNotFoundError:
        print(f"Error: Chunks file not found at {CHUNKS_FILE}")
        raise  # Re-raise exception to stop the application
    except Exception as e:
        print(f"Error loading chunks: {e}")
        all_chunks = None


# --- Fungsi Memuat Model ---
def load_model():
    global model
    model_name = 'paraphrase-multilingual-mpnet-base-v2'
    try:
        start_time = time.time()
        model = SentenceTransformer(model_name, device='cuda' if torch.cuda.is_available() else 'cpu')  # Gunakan GPU jika tersedia
        end_time = time.time()
        print(f"SentenceTransformer model loaded successfully in {end_time - start_time:.2f} seconds.")
    except Exception as e:
        print(f"Error loading model: {e}")
        model = None


# --- Muat Data ---
try:
    load_data()  # Hanya memuat data, model di-load secara lazy
except Exception as e:
    print(f"Fatal error during startup: {e}")
    exit(1)  # Stop the application if data loading fails

# --- Fungsi untuk Menjawab Pertanyaan ---
def answer_question(question: str, top_n: int = 3) -> str:
    global model
    if model is None:
        load_model()  # Load model hanya jika belum di-load

        if model is None: # Pastikan model berhasil dimuat
             return "Error: Failed to load the SentenceTransformer model."

    if embeddings is None or all_chunks is None:
        return "Error: Chatbot data not loaded properly."

    try:
        question_embedding = model.encode([question])[0]
        similarities = cosine_similarity([question_embedding], embeddings)[0]
        top_indices = np.argsort(similarities)[::-1][:top_n]

        context = "\n".join([all_chunks[i] for i in top_indices])
        return context
    except Exception as e:
        print(f"Error in answer_question: {e}")
        return "Error: An error occurred while processing the question." # Return error message

# --- Fungsi Post-processing Jawaban ---
def post_process_answer(answer: str) -> str:
    sentences = sent_tokenize(answer)
    bulleted_list = "<br>".join([f"* {sentence.strip()}" for sentence in sentences])
    return bulleted_list


# --- Model Request ---
class QuestionRequest(BaseModel):
    question: str


# --- API Endpoint ---
@app.post("/ask")
async def ask_chatbot(request: QuestionRequest):
    try:
        print(f"Received request: {request}")
        question = request.question
        if not question:
            raise HTTPException(status_code=400, detail="No question provided")

        raw_answer = answer_question(question)
        processed_answer = post_process_answer(raw_answer)

        return {"answer": processed_answer}

    except HTTPException as e:
        raise e
    except Exception as e:
        print(f"API error: {e}")
        raise HTTPException(status_code=500, detail="An error occurred processing the request")


# --- Endpoint Root ---
@app.get("/")
def read_root():
    return {"message": "API is running!"}


# --- Menjalankan Uvicorn ---
if __name__ == "__main__":
    port = int(os.getenv("PORT", 8000))
    print(f"Starting server on port {port}")
    uvicorn.run(app, host="0.0.0.0", port=port)