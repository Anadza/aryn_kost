class KamarModel {
  final int id;
  final String noKamar;
  final String tipe;
  final int harga;
  final String hargaFormatted;
  final String status;
  final String statusLabel;
  final String? foto;
  final String? fotoUrl;
  final String? kapasitas;
  final String? ukuran;
  final String? kasur;
  final List<String> fasilitas;

  KamarModel({
    required this.id,
    required this.noKamar,
    required this.tipe,
    required this.harga,
    required this.hargaFormatted,
    required this.status,
    required this.statusLabel,
    this.foto,
    this.fotoUrl,
    this.kapasitas,
    this.ukuran,
    this.kasur,
    required this.fasilitas,
  });

  factory KamarModel.fromJson(Map<String, dynamic> json) {
    return KamarModel(
      id: json['id'] as int,
      noKamar: json['no_kamar'] as String,
      tipe: json['tipe'] as String,
      harga: json['harga'] as int,
      hargaFormatted: json['harga_formatted'] as String,
      status: json['status'] as String,
      statusLabel: json['status_label'] as String,
      foto: json['foto'] as String?,
      fotoUrl: json['foto_url'] as String?,
      kapasitas: json['kapasitas'] as String?,
      ukuran: json['ukuran'] as String?,
      kasur: json['kasur'] as String?,
      fasilitas: json['fasilitas'] != null
          ? List<String>.from(json['fasilitas'] as List)
          : [],
    );
  }
}
