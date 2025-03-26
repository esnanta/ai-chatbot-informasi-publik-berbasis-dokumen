import os
import json
import nltk
import uvicorn
import numpy as np

from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from sentence_transformers import SentenceTransformer
from sklearn.metrics.pairwise import cosine_similarity
from nltk.tokenize import sent_tokenize

# nltk.download('punkt')
# nltk.download('punkt_tab')

nltk_data_path = "/opt/render/nltk_data/tokenizers"

if not os.path.exists(f"{nltk_data_path}/punkt"):
    nltk.download('punkt')

if not os.path.exists(f"{nltk_data_path}/punkt_tab"):
    nltk.download('punkt_tab')

app = FastAPI()

# --- CORS Configuration ---
origins = [
    "http://localhost",
    "http://localhost:80",
    "*",
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["POST"],
    allow_headers=["Content-Type"],
)

# --- Configuration ---
BASE_DIR = "knowledge_base"
EMBEDDINGS_FILE = os.path.join(BASE_DIR, "embeddings.npy")
CHUNKS_FILE = os.path.join(BASE_DIR, "chunks.json")

print(f"Embeddings file path: {EMBEDDINGS_FILE}")
print(f"Chunks file path: {CHUNKS_FILE}")

# --- Load Data ---
try:
    embeddings = np.load(EMBEDDINGS_FILE)
    print("Embeddings loaded from file.")
except Exception as e:
    print(f"Error loading embeddings: {e}")
    embeddings = None

try:
    with open(CHUNKS_FILE, "r", encoding="utf-8") as f:
        all_chunks = json.load(f)
    print("Chunks loaded from file.")
except Exception as e:
    print(f"Error loading chunks: {e}")
    all_chunks = None

# --- Load Sentence Transformer model ---
model_name = 'paraphrase-multilingual-mpnet-base-v2'
try:
    model = SentenceTransformer(model_name)
    print("SentenceTransformer model loaded.")
except Exception as e:
    print(f"Error loading SentenceTransformer model: {e}")
    model = None

# --- Function to Generate Answer ---
def answer_question(question: str, embeddings: np.ndarray, chunks: list, model: SentenceTransformer, top_n: int = 3) -> str:
    if embeddings is None or chunks is None or model is None:
        return "Error: Chatbot data not loaded properly."

    print(f"Question: {question}")

    question_embedding = model.encode([question])[0]
    similarities = cosine_similarity([question_embedding], embeddings)[0]
    top_indices = np.argsort(similarities)[::-1][:top_n]

    context = "\n".join([chunks[i] for i in top_indices])

    return context

# Fungsi untuk mengubah jawaban menjadi bullet list
def post_process_answer(answer: str) -> str:
    sentences = sent_tokenize(answer)
    bulleted_list = "<br>".join([f"* {sentence.strip()}" for sentence in sentences])
    return bulleted_list

# --- Request Body Model ---
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

        raw_answer = answer_question(question, embeddings, all_chunks, model)
        processed_answer = post_process_answer(raw_answer)

        return {"answer": processed_answer}

    except HTTPException as e:
        raise e
    except Exception as e:
        print(f"API error: {e}")
        raise HTTPException(status_code=500, detail="An error occurred processing the request")

@app.get("/")
def read_root():
    return {"message": "API is running!"}

if __name__ == "__main__":
    # Ambil port dari environment atau default ke 8000
    port = int(os.getenv("PORT", 8000))
    print(f"Starting server on port {port}")  # Debugging
    uvicorn.run(app, host="0.0.0.0", port=port)
    print("PORT from environment:", os.getenv("PORT"))