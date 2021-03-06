﻿# Host: localhost  (Version 5.5.5-10.1.34-MariaDB)
# Date: 2018-11-05 14:39:33
# Generator: MySQL-Front 6.0  (Build 2.29)


#
# Structure for table "arsip_surat_masuk"
#

DROP TABLE IF EXISTS `arsip_surat_masuk`;
CREATE TABLE `arsip_surat_masuk` (
  `idarsip_surat` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_surat` varchar(50) DEFAULT NULL COMMENT 'sesuai nomor di surat',
  `lampiran` varchar(50) DEFAULT NULL COMMENT 'isi lampiran',
  `tujuan` varchar(50) DEFAULT NULL COMMENT 'orang/bagian/organisasi penerima surat',
  `pengirim` varchar(100) DEFAULT NULL COMMENT 'nama/bagian/perusahaan/organisasi pengirim surat',
  `tg_surat` date DEFAULT NULL,
  `berkas` varchar(100) DEFAULT NULL COMMENT 'link file dari surat',
  `idkategori_surat` int(11) NOT NULL,
  `idpejabat` int(11) NOT NULL,
  `status` enum('true','false') DEFAULT 'false',
  PRIMARY KEY (`idarsip_surat`),
  KEY `fk_arsip_surat_masuk_kategori_surat1_idx` (`idkategori_surat`),
  KEY `fk_arsip_surat_masuk_pejabat1_idx` (`idpejabat`),
  CONSTRAINT `fk_arsip_surat_masuk_kategori_surat1` FOREIGN KEY (`idkategori_surat`) REFERENCES `kategori_surat` (`idkategori_surat`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_arsip_surat_masuk_pejabat1` FOREIGN KEY (`idpejabat`) REFERENCES `pejabat` (`idpejabat`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "arsip_surat_masuk"
#


#
# Structure for table "kategori_surat"
#

DROP TABLE IF EXISTS `kategori_surat`;
CREATE TABLE `kategori_surat` (
  `idkategori_surat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(45) DEFAULT NULL COMMENT 'contoh isian : keputusan dll',
  `keterangan` varchar(250) DEFAULT NULL COMMENT 'karakteristik dari kategori surat',
  PRIMARY KEY (`idkategori_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "kategori_surat"
#

INSERT INTO `kategori_surat` VALUES (1,'Surat Keputusan','Kepentingan Surat Keputusan'),(2,'Surat Peintah','Kepentingan Surat Peritah');

#
# Structure for table "pengguna"
#

DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE `pengguna` (
  `idpengguna` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pengguna` varchar(100) DEFAULT NULL COMMENT 'struktural stimik',
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `akses` enum('admin','struktural') NOT NULL DEFAULT 'struktural',
  PRIMARY KEY (`idpengguna`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "pengguna"
#

INSERT INTO `pengguna` VALUES (1,'Muhammad Rajab','rajab12','7F975A56C761DB6506ECA0B37CE6EC87','rajab12@gmail.com','admin'),(2,'Ajenkris Y. Kungkung','kristt26','ac20a86151bb896d10e636a0a91696fa','kristt26@gmail.com','struktural'),(3,'Budi','budi','ac20a86151bb896d10e636a0a91696fa','budi@gmail.com','struktural'),(4,'Rahmat H. Kiswanto','rahmat','ac20a86151bb896d10e636a0a91696fa','rahmat@gmail.com','struktural'),(5,'Sariyati H. Y. Bei','sari','ac20a86151bb896d10e636a0a91696fa','sari@gmail.com','struktural');

#
# Structure for table "struktural"
#

DROP TABLE IF EXISTS `struktural`;
CREATE TABLE `struktural` (
  `idstruktural` int(11) NOT NULL AUTO_INCREMENT,
  `nm_struktural` varchar(45) NOT NULL,
  PRIMARY KEY (`idstruktural`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Data for table "struktural"
#

INSERT INTO `struktural` VALUES (1,'Admin'),(2,'Laboratorium'),(3,'Jurusan'),(4,'Puket I Akademik'),(5,'Puket 2 Keuangan'),(6,'Puket 3 Kemahasiswaan'),(7,'PLH');

#
# Structure for table "pejabat"
#

DROP TABLE IF EXISTS `pejabat`;
CREATE TABLE `pejabat` (
  `idpejabat` int(11) NOT NULL AUTO_INCREMENT,
  `idpengguna` int(11) NOT NULL,
  `idstruktural` int(11) NOT NULL,
  `status` enum('true','false') DEFAULT 'true',
  PRIMARY KEY (`idpejabat`),
  KEY `fk_pejabat_pengguna1_idx` (`idpengguna`),
  KEY `fk_pejabat_struktural1_idx` (`idstruktural`),
  CONSTRAINT `fk_pejabat_pengguna1` FOREIGN KEY (`idpengguna`) REFERENCES `pengguna` (`idpengguna`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pejabat_struktural1` FOREIGN KEY (`idstruktural`) REFERENCES `struktural` (`idstruktural`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "pejabat"
#

INSERT INTO `pejabat` VALUES (1,1,1,'true'),(2,2,2,'true'),(3,3,5,'true'),(4,4,4,'true'),(5,5,7,'true');

#
# Structure for table "arsip_surat_internal"
#

DROP TABLE IF EXISTS `arsip_surat_internal`;
CREATE TABLE `arsip_surat_internal` (
  `idarsip_surat` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_surat` varchar(50) DEFAULT NULL COMMENT 'sesuai nomor di surat',
  `lampiran` varchar(50) DEFAULT NULL COMMENT 'isi lampiran',
  `tujuan` int(11) NOT NULL,
  `pengirim` int(11) NOT NULL,
  `tg_surat` date DEFAULT NULL,
  `berkas` varchar(100) DEFAULT NULL COMMENT 'link file dari surat',
  `idkategori_surat` int(11) NOT NULL,
  `status` enum('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`idarsip_surat`),
  KEY `fk_arsip_surat_kategori_surat1_idx` (`idkategori_surat`),
  KEY `fk_arsip_surat_internal_pejabat1_idx` (`tujuan`),
  KEY `fk_arsip_surat_internal_pejabat2_idx` (`pengirim`),
  CONSTRAINT `fk_arsip_surat_internal_pejabat1` FOREIGN KEY (`tujuan`) REFERENCES `pejabat` (`idpejabat`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_arsip_surat_internal_pejabat2` FOREIGN KEY (`pengirim`) REFERENCES `pejabat` (`idpejabat`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_arsip_surat_kategori_surat1` FOREIGN KEY (`idkategori_surat`) REFERENCES `kategori_surat` (`idkategori_surat`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "arsip_surat_internal"
#


#
# Structure for table "tembusan"
#

DROP TABLE IF EXISTS `tembusan`;
CREATE TABLE `tembusan` (
  `idtembusan` int(11) NOT NULL AUTO_INCREMENT,
  `idarsip_surat` int(11) NOT NULL,
  `idpejabat` int(11) NOT NULL,
  PRIMARY KEY (`idtembusan`),
  KEY `fk_tembusan_arsip_surat1_idx` (`idarsip_surat`),
  KEY `fk_tembusan_pejabat1_idx` (`idpejabat`),
  CONSTRAINT `fk_tembusan_arsip_surat1` FOREIGN KEY (`idarsip_surat`) REFERENCES `arsip_surat_internal` (`idarsip_surat`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tembusan_pejabat1` FOREIGN KEY (`idpejabat`) REFERENCES `pejabat` (`idpejabat`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "tembusan"
#

