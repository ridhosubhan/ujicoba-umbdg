<!-- Modal Store Potongan -->
<form id="formPotongan">
    <div class="modal fade" style="overflow:hidden;" id="tambahPotonganModal" aria-labelledby="tambahPotonganModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5">
                        <strong>Tambah Data Potongan</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="pegawai_id" id="pegawai_id" value="<?= $profil->id ?>" readonly />
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="bulan_potongan" class="form-label">Bulan <span class="text-danger">*</span></label>
                            <select name="bulan_potongan" id="bulan_potongan" class="form-control select2">
                                <option value="" selected disabled>Bulan</option>
                                <?php foreach ($tahun_gajian as $row) : ?>
                                    <option value="<?= $row["bulan"] ?>">
                                        <?= $row["bulan"] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback errorBulanPotongan">
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="potongan" class="form-label">Potongan <span class="text-danger">*</span></label>
                            <select name="potongan" id="potongan" class="form-control select2">
                                <option value="" selected disabled>Pilih Potongan</option>
                                <?php foreach ($ref_potongan as $row) : ?>
                                    <option value="<?= $row["id"] ?>">
                                        <?php if (!empty($row["keterangan"])) : ?>
                                            <?= $row["nama"] ?> - <?= $row["keterangan"] ?> - <?= ucfirst("Rp ") . number_format($row["nominal"], 0, ",", ".") ?>
                                        <?php else : ?>
                                            <?= $row["nama"] ?> - <?= ucfirst("Rp ") . number_format($row["nominal"], 0, ",", ".") ?>
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback errorPotongan">
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="potongan_perbulan" class="form-label">Potongan Rutin Perbulan <span class="text-danger">*</span></label>
                            <select name="potongan_perbulan" id="potongan_perbulan" class="form-control select2">
                                <option value="" selected disabled>Pilih</option>
                                <option value="1">Ya</option>
                                <option value="2">Tidak</option>
                            </select>
                            <div class="invalid-feedback errorPotonganPerbulan">
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
<!-- Modal Store Potongan -->

<!-- Modal Edit Rekening -->
<form id="formRekening">
    <div class="modal fade" id="editRekeningModal" aria-labelledby="editRekeningModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5">
                        <strong>Edit Rekening</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="rekening_id" id="rekening_id" value="<?= $profil->rekening_id ?>" readonly />
                    <div class="form-row mt-2">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label for="no_rekening" class="form-label">No. Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="no_rekening" id="no_rekening" class="form-control">
                            <div class="invalid-feedback errorNoRekening">
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label for="bank" class="form-label">Bank <span class="text-danger">*</span></label>
                            <input type="text" name="bank" id="bank" class="form-control">
                            <div class="invalid-feedback errorBank">
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                            <div class="invalid-feedback errorKeterangan">
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
<!-- Modal Edit Gaji Pokok -->