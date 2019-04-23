CREATE TABLE Klien(
	idC int IDENTITY(1,1) NOT NULL,
	nama_C varchar(30) NOT NULL,
	statusKawin int NOT NULL,
	tanggal_Lahir date NOT NULL,
	nilai_investasi money NOT NULL,
	umur int NOT NULL,
	alamat int NOT NULL,
	idU int NOT NULL
);
CREATE TABLE Kota(
	idK int IDENTITY(1,1) NOT NULL,
	nama_K varchar(30) NOT NULL
);
CREATE TABLE Region(
	idR int IDENTITY(1,1) NOT NULL,
	nama_R varchar(30) NOT NULL
);
CREATE TABLE TerdapatDi(
	idK int NOT NULL,
	idR int NOT NULL
);
CREATE TABLE Kontak(
	idU int NOT NULL,
	kontak varchar(10) NOT NULL
)
CREATE TABLE Users(
	nama varchar(30) NOT NULL,
	tanggal_Gabung date NOT NULL,
	username varchar(20) NOT NULL,
	password varchar(20) NOT NULL,
	idU int IDENTITY(1,1) NOT NULL,
	active int NOT NULL
);
ALTER TABLE Kota
	ADD CONSTRAINT [PK-Kota]
	PRIMARY KEY(
		idK
	)
ALTER TABLE Region
	ADD CONSTRAINT [PK-Region]
	PRIMARY KEY(
		idR
	)
ALTER TABLE TerdapatDi
	ADD CONSTRAINT [FK_T-K]
	FOREIGN KEY(idK)
	REFERENCES
		Kota(idK)
ALTER TABLE TerdapatDi
	ADD CONSTRAINT [FK_T-R]
	FOREIGN KEY(idR)
	REFERENCES
		Region(idR)
ALTER TABLE Klien
	ADD CONSTRAINT [PK-Klien]
	PRIMARY KEY(
		idC
	)
ALTER TABLE Klien
	ADD CONSTRAINT [FK_C-K]
	FOREIGN KEY(alamat)
	REFERENCES
		Kota(idK)
ALTER TABLE Users
	ADD CONSTRAINT [PK-Users]
	PRIMARY KEY(
		idU
	)
ALTER TABLE Klien
	ADD CONSTRAINT [FK_C-C]
	FOREIGN KEY(idU)
	REFERENCES
		Users(idU)
ALTER TABLE Kontak
	ADD CONSTRAINT [FK_Kontak]
	FOREIGN KEY(idU)
	REFERENCES
		Users(idU)