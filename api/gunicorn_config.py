bind = "0.0.0.0:10000"  # Port Render default: 10000
workers = 4  # Jumlah worker (sesuaikan dengan CPU)
worker_class = "uvicorn.workers.UvicornWorker"  # Gunakan worker Uvicorn
timeout = 120  # Timeout 120 detik
loglevel = "info"  # Level log