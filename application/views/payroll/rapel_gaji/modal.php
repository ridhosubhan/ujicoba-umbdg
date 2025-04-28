<form id="formSubmit">
    <div class="modal fade" style="overflow:hidden;" id="tambahModal" aria-labelledby="tambahModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5">
                        <strong>Tambah Data</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                            <input type="text" name="bulan" id="bulan" class="form-control" value="<?= date('Ym') ?>" />
                            <div class="invalid-feedback errorBulan"></div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="pegawai" class="form-label">Pegawai <span class="text-danger">*</span></label>
                            <select name="pegawai" id="pegawai" class="form-control select2">
                                <option value="" selected disabled>Pilih Pegawai</option>
                                <?php foreach ($pegawai as $row) : ?>
                                    <option value="<?= $row["peg_id"] ?>">
                                        <?= nama_gelar_lengkap_ucwords($row["nama_depan"], $row["nama_tengah"], $row["nama_belakang"], $row["gelar_depan"], $row["gelar_belakang"]) ?> - <?= $row["status_kepegawaian"] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback errorPotongan">
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="rapel_gaji" class="form-label">Rapel Gaji <span class="text-danger">*</span></label>
                            <input type="number" name="rapel_gaji" id="rapel_gaji" class="form-control" />
                            <div class="invalid-feedback errorRapelGaji">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary buttonBatal" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary buttonSimpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>