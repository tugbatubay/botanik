



CREATE TABLE kullanicilar (
    id INT AUTO_INCREMENT PRIMARY KEY,  
    kullanici_adi VARCHAR(50) NOT NULL UNIQUE,   
    sifre VARCHAR(255) NOT NULL,           
    kayit_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
);



CREATE TABLE bitkiler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kullanici_id INT NOT NULL,          
    bitki_adi VARCHAR(100) NOT NULL,           
    tur_adi VARCHAR(100) NOT NULL,          
    bakim_notu TEXT,                            
    sulama_periyodu VARCHAR(50),                     
    eklenme_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kullanici_id) REFERENCES kullanicilar(id)
);