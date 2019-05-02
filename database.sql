CREATE TABLE Users(
	nama varchar(30) NOT NULL,
	tanggalGabung date NOT NULL,
	username varchar(20) NOT NULL,
	password varchar(20) NOT NULL,
	idU int AUTO_INCREMENT NOT NULL,
	active int NOT NULL,
	status int NOT NULL,
	PRIMARY KEY (idU)
);
CREATE TABLE Kota(
	idK int AUTO_INCREMENT,
	namaKota varchar(30) NOT NULL,
	PRIMARY KEY (idK)
);
CREATE TABLE Client(
	idC int AUTO_INCREMENT NOT NULL,
	namaClient varchar(30) NOT NULL,
	statusKawin int NOT NULL,
	tanggalLahir date NOT NULL,
	nilaiInvestasi decimal(15,2) NOT NULL,
	alamat int NULL,
	gender int NULL,
	gambar MEDIUMTEXT,
	idU int NOT NULL,
	PRIMARY KEY (idC),
	CONSTRAINT FK_usercs FOREIGN KEY (idU) REFERENCES Users(idU),
	CONSTRAINT FK_alamat FOREIGN KEY (alamat) REFERENCES Kota(idK)
);
CREATE TABLE Region(
	idR int AUTO_INCREMENT NOT NULL,
	namaRegion varchar(30) NOT NULL,
	PRIMARY KEY (idR)
);
CREATE TABLE TerdapatDi(
	idK int NOT NULL,
	idR int NOT NULL,
	CONSTRAINT FK_tk FOREIGN KEY (idK) REFERENCES Kota(idK),
	CONSTRAINT FK_tr FOREIGN KEY (idR) REFERENCES Region(idR)
);
CREATE TABLE Kontak(
	idU int NOT NULL,
	kontak varchar(50) NOT NULL,
	CONSTRAINT FK_Kontak FOREIGN KEY (idU) REFERENCES Users(idU)
);
CREATE VIEW viewUmurClient as
SELECT *, YEAR(DATEDIFF(Client.tanggalLahir, CURDATE())) as umur
FROM Client

CREATE INDEX idxUser ON users(nama);
CREATE INDEX idxClient ON client(namaClient);
CREATE INDEX idxKota ON kota(namaKota);
CREATE INDEX idxReg ON region(namaRegion);
