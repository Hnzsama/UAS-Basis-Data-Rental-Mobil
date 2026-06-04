import os
import mysql.connector

def load_dotenv():
    dotenv_path = os.path.join(os.path.dirname(__file__), ".env")
    if os.path.exists(dotenv_path):
        with open(dotenv_path, "r") as f:
            for line in f:
                line = line.strip()
                if not line or line.startswith("#"):
                    continue
                if "=" in line:
                    key, val = line.split("=", 1)
                    os.environ[key.strip()] = val.strip().strip('"').strip("'")

# Load environment variables from .env file
load_dotenv()

def connect_db():
    return mysql.connector.connect(
        host=os.environ.get("DB_HOST", "localhost"),
        user=os.environ.get("DB_USER", "root"),
        password=os.environ.get("DB_PASSWORD", ""),
        database=os.environ.get("DB_DATABASE", "uas_rental_mobil")
    )

# --- CRUD TABEL MOBIL ---
def create_mobil(merek, model, plat, harga):
    db = connect_db()
    cursor = db.cursor()
    sql = "INSERT INTO mobil (merek, model, plat_nomor, harga_sewa_perhari) VALUES (%s, %s, %s, %s)"
    cursor.execute(sql, (merek, model, plat, harga))
    db.commit()
    print("Mobil berhasil ditambahkan!")
    db.close()

def read_mobil():
    db = connect_db()
    cursor = db.cursor()
    cursor.execute("SELECT * FROM mobil")
    for row in cursor.fetchall():
        print(row)
    db.close()

def update_mobil(id_mobil, harga):
    db = connect_db()
    cursor = db.cursor()
    sql = "UPDATE mobil SET harga_sewa_perhari = %s WHERE id_mobil = %s"
    cursor.execute(sql, (harga, id_mobil))
    db.commit()
    print("Harga mobil berhasil diperbarui!")
    db.close()

def delete_mobil(id_mobil):
    db = connect_db()
    cursor = db.cursor()
    sql = "DELETE FROM mobil WHERE id_mobil = %s"
    cursor.execute(sql, (id_mobil,))
    db.commit()
    print("Mobil berhasil dihapus!")
    db.close()

def main():
    while True:
        print("\n=== MENU CRUD MOBIL (PYTHON) ===")
        print("1. Tambah Mobil (Create)")
        print("2. Tampilkan Daftar Mobil (Read)")
        print("3. Perbarui Harga Sewa Mobil (Update)")
        print("4. Hapus Mobil (Delete)")
        print("5. Keluar")
        
        pilihan = input("Pilih menu (1-5): ").strip()
        
        if pilihan == "1":
            print("\n--- Tambah Mobil ---")
            merek = input("Merek: ").strip()
            model = input("Model: ").strip()
            plat = input("Plat Nomor: ").strip()
            try:
                harga = int(input("Harga Sewa Per Hari: ").strip())
                create_mobil(merek, model, plat, harga)
            except ValueError:
                print("Error: Harga sewa harus berupa angka!")
        elif pilihan == "2":
            print("\n--- Daftar Mobil ---")
            read_mobil()
        elif pilihan == "3":
            print("\n--- Perbarui Harga Sewa ---")
            try:
                id_mobil = int(input("ID Mobil yang ingin diupdate: ").strip())
                harga = int(input("Harga Sewa Baru: ").strip())
                update_mobil(id_mobil, harga)
            except ValueError:
                print("Error: ID Mobil dan Harga harus berupa angka!")
        elif pilihan == "4":
            print("\n--- Hapus Mobil ---")
            try:
                id_mobil = int(input("ID Mobil yang ingin dihapus: ").strip())
                delete_mobil(id_mobil)
            except ValueError:
                print("Error: ID Mobil harus berupa angka!")
        elif pilihan == "5":
            print("Keluar dari program. Terima kasih!")
            break
        else:
            print("Pilihan tidak valid! Silakan masukkan 1-5.")

# Contoh Eksekusi Python
if __name__ == "__main__":
    main()
