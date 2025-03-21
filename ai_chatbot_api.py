from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import os
import json
import uvicorn
import numpy as np
from sentence_transformers import SentenceTransformer
from sklearn.metrics.pairwise import cosine_similarity

app = FastAPI()

# --- Configuration ---
BASE_DIR = "knowledge_base"  # Directory containing all data files
EMBEDDINGS_FILE = os.path.join(BASE_DIR, "embeddings.npy")
CHUNKS_FILE = os.path.join(BASE_DIR, "chunks.json")

print(f"Embeddings file path: {EMBEDDINGS_FILE}")  # Add this line for debugging
print(f"Chunks file path: {CHUNKS_FILE}")  # Add this line for debugging

# --- Load Data ---
try:
    embeddings = np.load(EMBEDDINGS_FILE)
    print("Embeddings loaded from file.")
except Exception as e:
    print(f"Error loading embeddings: {e}")
    embeddings = None  # Handle the case where embeddings fail to load

try:
    with open(CHUNKS_FILE, "r", encoding="utf-8") as f:
        all_chunks = json.load(f)
    print("Chunks loaded from file.")
except Exception as e:
    print(f"Error loading chunks: {e}")
    all_chunks = None  # Handle the case where chunks fail to load

# --- Load Sentence Transformer model (multilingual) ---
model_name = 'paraphrase-multilingual-mpnet-base-v2'  # Or your chosen model
try:
    model = SentenceTransformer(model_name)
    print("SentenceTransformer model loaded.")
except Exception as e:
    print(f"Error loading SentenceTransformer model: {e}")
    model = None  # Handle model loading failure

# --- Question Answering Function ---
def answer_question(question: str, embeddings: np.ndarray, chunks: list, model: SentenceTransformer, top_n: int = 3) -> str:
    """Answers a question based on the text chunks."""
    if embeddings is None or chunks is None or model is None:
        return "Error: Chatbot data not loaded properly."

    print(f"Question: {question}")  # Debugging: Print the question

    question_embedding = model.encode([question])[0]
    print(f"Question embedding shape: {question_embedding.shape}")  # Debugging: Print the shape

    similarities = cosine_similarity([question_embedding], embeddings)[0]
    print(f"Similarities shape: {similarities.shape}")  # Debugging: Print the shape
    print(f"Example similarities: {similarities[:5]}") # Debugging: Check some values

    top_indices = np.argsort(similarities)[::-1][:top_n]
    print(f"Top indices: {top_indices}")  # Debugging: Print the top indices

    context = "\n".join([chunks[i] for i in top_indices])
    print(f"Context:\n{context}")  # Debugging: Print the context

    return context

# --- Request Body Model ---
class QuestionRequest(BaseModel):
    question: str

# --- API Endpoint ---
@app.post("/ask")
async def ask_chatbot(request: QuestionRequest):
    """API endpoint to answer questions."""
    try:
        question = request.question
        if not question:
            raise HTTPException(status_code=400, detail="No question provided")

        answer = answer_question(question, embeddings, all_chunks, model)
        return {"answer": answer}

    except HTTPException as e:
        raise e
    except Exception as e:
        print(f"API error: {e}")
        raise HTTPException(status_code=500, detail="An error occurred processing the request")

if __name__ == "__main__":
    uvicorn.run(app, host="0.0.0.0", port=8000)