# AI Chatbot for Public Information Service 
Case Study : Dana BOS (Permendikbudristek No. 63/2023)

## Overview

This project is an early prototype of an AI-powered chatbot designed to provide information related to the Indonesian Ministry of Education, Culture, Research, and Technology Regulation (Permendikbudristek) Number 63 of 2023.  The chatbot focuses on answering questions about the management of School Operational Assistance Funds (BOSP), including BOP PAUD (Early Childhood Education Operational Assistance), BOS (School Operational Assistance), and BOP Kesetaraan (Equality Education Operational Assistance).

The chatbot utilizes a **sentence transformer** approach.  This means that the phrasing and keywords used in questions significantly impact the accuracy and relevance of the answers provided.  Users are encouraged to use specific phrases found within the Permendikbudristek No. 63/2023 regulation for optimal results.

**This is an early prototype and may not always provide accurate or complete answers.**  The chatbot's responses are based on the available regulatory documents and should *not* be considered legal advice.  The chatbot may sometimes provide generic or repetitive answers.

## Architecture

The project consists of two main components:

*   **API:** Developed using **Python** (FastAPI). This component handles the core question-answering logic, utilizing the sentence transformer model and the processed regulatory text.
*   **UI:** Developed using **PHP** (Yii2). This component provides the user interface for interacting with the chatbot, sending questions to the API, and displaying the responses.

## Current Limitations

*   **Limited Scope:** The chatbot currently only answers questions directly related to the content of Permendikbudristek No. 63/2023.
*   **Phrase Sensitivity:** The quality of answers is highly dependent on the phrasing of the question. Questions that are too general or use terms outside the regulatory document may produce less relevant results.
*   **No Legal Interpretation:** The chatbot is not designed to provide legal interpretation or professional advice.
*   **Potential for Repetitive Answers:** In some cases, the chatbot may provide similar answers to different questions that have similar phrasing.

## Feedback

User feedback is crucial for improving the quality of this service.  Please use the *upvote* (👍) or *downvote* (👎) buttons after receiving an answer to provide feedback. Your input is invaluable for the further development of this program.

## Installation and Setup

1.  **Python Environment:**
   *   It's highly recommended to use a virtual environment:
       ```bash
       python3 -m venv venv
       source venv/bin/activate  # On Linux/macOS
       venv\Scripts\activate    # On Windows
       ```
   *   Install the required Python packages
       ```bash
       pip install -r requirements.txt
       ```

2.  **Data Preparation:**
   *   Place the PDF file(s) of Permendikbudristek No. 63/2023 in a designated directory (e.g., `knowledge_base`).
   *   Run the Python script that extracts text, preprocesses it, creates chunks, and generates embeddings. This script will typically save the embeddings and chunks to files (e.g., `embeddings.npy`, `chunks.json`).  Adapt the paths within the script as needed.

3.  **FastAPI API:**
   *   Start the FastAPI server (usually with `uvicorn`):
       ```bash
       uvicorn main:app --host 0.0.0.0 --port 8000
       ```
4.  **PHP (Yii2) Environment:**
   *   Ensure you have a web server (e.g., Apache, Nginx) configured to serve the Yii2 application.
   *   Configure the Yii2 application (database connection, URL manager, etc.) as needed. 

5. **Run**
   * Access the application through browser.

## Contributing

Contributions to this project are welcome!

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.