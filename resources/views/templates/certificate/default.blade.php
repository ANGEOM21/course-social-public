<!DOCTYPE html>
<html lang="id">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Certificate of Appreciation</title>
  <style>
    /* ==== Font custom (mPDF butuh path file lokal) ==== */
    @font-face {
      font-family: 'AlexBrush';
      src: url("{{ public_path('fonts/Alex_Brush/AlexBrush-Regular.ttf') }}") format('truetype');
      font-weight: normal;
      font-style: normal;
    }

    /* ==== Halaman ==== */
    @page {
      size: A4 landscape;
      margin: 0;
    }

    body {
      margin: 0;
      font-family: 'Times New Roman', Times, serif;
      background: #0F172A;
      /* bingkai luar gelap */
    }

    .frame {
      background: #ffffff;
      color: #303841;
      padding: 0;
      box-sizing: border-box;
    }

    /* ==== Header ==== */
    .header {
      background: #303841;
      color: #FBBF24;
      text-align: center;
      padding: 10mm 0 8mm;
    }

    .header .title {
      font-size: 45pt;
      font-weight: 700;
      letter-spacing: 1px;
      line-height: 1;
    }

    .header .subtitle {
      font-size: 18pt;
      font-weight: 700;
      letter-spacing: 2px;
      margin-top: 2mm;
    }

    /* ==== Konten utama ==== */
    .content {
      text-align: center;
      padding: 10mm 20mm 10mm;
    }

    .presented {
      font-size: 28pt;
      font-weight: 700;
      color: #334155;
      letter-spacing: 1px;
      margin-bottom: 10mm;
    }

    .student {
      font-family: 'AlexBrush', cursive;
      font-size: 45pt;
      font-weight: normal;
      color: #0F172A;
      letter-spacing: 1px;
      margin-bottom: 8mm;
    }

    .desc {
      width: 75%;
      margin: 0 auto;
      color: #334155;
      font-size: 12pt;
      line-height: 1.6;
    }

    /* Logo/watermark aman */
    .logo {
      display: block;
      margin: 0 auto 6mm;
      opacity: .06;
      max-width: 140mm;
      height: auto;
    }

    /* ==== Area tanda tangan ==== */
    .sign-wrap {
      padding: 5mm 16mm 20mm 12mm;
      color: #303841;
    }

    table.sigs {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
    }

    table.sigs td {
      width: 50%;
      text-align: center;
      vertical-align: bottom;
      padding: 0 10mm;
    }

    .sig {
      display: block;
      width: 100%;
    }

    /* Kotak gambar TTD (seragam) */
    /* kotak tanda tangan */
    .sig-area {
      height: 38mm;
      margin: 0 auto 4mm;
    }

    .sig-img {
      display: block;
      height: 28mm;
      width: auto;
      max-width: 100%;
      margin: 0 auto;
    }

    /* boost khusus buat Siraj biar setara */
    .sig-img--siraj {
      top: -25mm;
      position: relative;
      height: 100mm;
    }
    .sig-img--angeom {
      top: 5mm;
      position: relative;
      height: 40mm;
    }

    /* naikin 6mm */


    /* Garis dan teks nama/jabatan */
    .sig-line {
      width: 75%;
      height: 0;
      border-bottom: 1.6pt solid #303841;
      margin: 2mm auto 2mm;
    }

    .sig-name {
      font-weight: 700;
      font-size: 12pt;
      color: #303841;
    }

    .sig-title {
      font-size: 10pt;
      color: #374151;
    }

    .meta {
      text-align: center;
      margin-top: 6mm;
      color: #6B7280;
      font-size: 9pt;
    }
  </style>
</head>

<body>
  <div class="page-wrap">
    <div class="frame">
      <!-- Header -->
      <div class="header">
        <div class="title">CERTIFICATE</div>
        <div class="subtitle">OF APPRECIATION</div>
      </div>

      <!-- Konten -->
      <div class="content">
        <!-- Watermark/logo opsional -->
        <img src="{{ asset('logo-sertifikat.png') }}" alt="Logo" class="logo">

        <div class="presented">THIS CERTIFICATE PRESENTED TO</div>
        <div class="student">{nama_student}</div>

        <div class="desc">
          Diberikan sebagai apresiasi telah menyelesaikan course:
          <strong>{course}</strong> dengan penuh dedikasi dan komitmen dalam proses pembelajaran.
          <br />Diselesaikan pada: {tanggal}
        </div>
      </div>

      <!-- Tanda Tangan -->
      <div class="sign-wrap">
        <table class="sigs">
          <tr>
            <td>
              <div class="sig">
                <div class="sig-area">
                  <img class="sig-img sig-img--siraj" src="{{ asset('ttd-siraj.png') }}" alt="TTD Siraj">
                </div>
                <div class="sig-line"></div>
                <div class="sig-name">Siraj Nurul Bil Haq</div>
                <div class="sig-title">Ketua Umum Social Republic</div>
              </div>
            </td>
            <td>
              <div class="sig">
                <div class="sig-area">
                  <img class="sig-img sig-img--angeom" src="{{ asset('ttd-angeom.png') }}" alt="TTD Mentor">
                </div>
                <div class="sig-line"></div>
                <div class="sig-name">Fahmi Idris Anjounghan</div>
                <div class="sig-title">Mentor</div>
              </div>
            </td>
          </tr>
        </table>

        <div class="meta">{kode_course}</div>
      </div>
    </div>
  </div>
</body>

</html>
