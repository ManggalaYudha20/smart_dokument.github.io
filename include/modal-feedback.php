<?php
$date = date("d M Y");
$time = date("h:i");
?>
<?php if (empty($rowFeedbackUser)) : ?>
	<!-- Modal Send Feedback -->
	<div class="modal fade" id="feedBack" tabindex="-1" role="dialog" aria-labelledby="feedBack" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Berikan Feedback kamu</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="" method="post">
						<input type="text" hidden name="id_user" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["id"]))))))))); ?>">
						<input type="text" hidden name="gambar" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["gambar"]))))))))); ?>">
						<input type="text" hidden name="first_name" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["first_name"]))))))))); ?>">
						<input type="text" hidden name="last_name" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["last_name"]))))))))); ?>">
						<div class="form-group row">
							<div class="col-sm-6">
								<label for="phone"><i class="fa fa-mobile-alt"></i> Nomor Telepon/WA</label>
								<input type="asd" name="phone" id="phone" placeholder="Masukan nomor telepon atau wa" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Nomor telelpon atau wa harus diisi')" oninput="setCustomValidity('')">
							</div>
							<div class="col-sm-6">
								<label for="email"><i class="fa fa-envelope"></i> Alamat Email</label>
								<input type="email" name="email" id="email" placeholder="your@mail.com" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Alamat email harus diisi')" oninput="setCustomValidity('')">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12">
								<label for="description"><i class="fa fa-file-text-alt"></i> Deskripsi masukan</label>
								<textarea name="description" id="description" required oninvalid="this.setCustomValidity('Nomor telelpon atau wa harus diisi')" oninput="setCustomValidity('')" class="form-control form-control-user" placeholder="Terimakasih..."></textarea>
							</div>
						</div>
						<div class="form-group row form-group-feedback">
							<div class="col-6 col-sm-2">
								<label class="imagecheck mb-3">
									<input name="response" type="radio" value="Sangat Baik" class="imagecheck-input" checked="">
									<figure class="imagecheck-figure">
										<img src="<?php include("url.php"); ?>assets/img/feedback/happy.png" alt="title" class="imagecheck-image">
									</figure>
									<span style="font-size:9px;">Sangat Baik</span>
								</label>
							</div>
							<div class="col-6 col-sm-2">
								<label class="imagecheck mb-3">
									<input name="response" type="radio" value="Baik" class="imagecheck-input">
									<figure class="imagecheck-figure">
										<img src="<?php include("url.php"); ?>assets/img/feedback/smile.png" alt="title" class="imagecheck-image">
									</figure>
									<span style="font-size:9px;">Baik</span>
								</label>
							</div>
							<div class="col-6 col-sm-2">
								<label class="imagecheck mb-3">
									<input name="response" type="radio" value="Sedang" class="imagecheck-input">
									<figure class="imagecheck-figure">
										<img src="<?php include("url.php"); ?>assets/img/feedback/confused.png" alt="title" class="imagecheck-image">
									</figure>
									<span style="font-size:9px;">Sedang</span>
								</label>
							</div>
							<div class="col-6 col-sm-2">
								<label class="imagecheck mb-3">
									<input name="response" type="radio" value="Buruk" class="imagecheck-input">
									<figure class="imagecheck-figure">
										<img src="<?php include("url.php"); ?>assets/img/feedback/sad1.png" alt="title" class="imagecheck-image">
									</figure>
									<span style="font-size:9px;">Buruk</span>
								</label>
							</div>
							<div class="col-6 col-sm-2">
								<label class="imagecheck mb-3">
									<input name="response" type="radio" value="Sangat Buruk" class="imagecheck-input">
									<figure class="imagecheck-figure">
										<img src="<?php include("url.php"); ?>assets/img/feedback/sad2.png" alt="title" class="imagecheck-image">
									</figure>
									<span style="font-size:9px;">Sangat Buruk</span>
								</label>
							</div>
							<input type="text" hidden name="date" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($date))))))))); ?>">
							<input type="text" hidden name="time" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($time))))))))); ?>">
							<input type="text" hidden name="status" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($readFeeadbackUser))))))))); ?>">
							<input type="text" hidden name="status_all" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($readAllFeeadbackUser))))))))); ?>">
							<input type="text" hidden name="status_update" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($statusUpdateFeedbackUser0))))))))); ?>">
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" name="send_feedback" class="btn btn-primary">Kirim Feedback</button>
				</div>
				</form>
			</div>
		</div>
	</div>
<?php endif; ?>


<?php if ($rowFeedbackUser["status_update"] !== "1") : ?>
	<?php if (!empty($rowFeedbackUser)) : ?>
		<!-- Modal Update Feedback -->
		<div class="modal fade" id="feedBack" tabindex="-1" role="dialog" aria-labelledby="feedBack" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Feedback kamu</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="" method="post">
							<input type="text" hidden name="id" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowFeedbackUser["id"]))))))))); ?>">
							<input type="text" hidden name="id_user" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowFeedbackUser["id_user"]))))))))); ?>">
							<input type="text" hidden name="gambar" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowFeedbackUser["gambar"]))))))))); ?>">
							<input type="text" hidden name="first_name" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowFeedbackUser["first_name"]))))))))); ?>">
							<input type="text" hidden name="last_name" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowFeedbackUser["last_name"]))))))))); ?>">
							<div class="form-group row">
								<div class="col-sm-6">
									<label for="phone"><i class="fa fa-mobile-alt"></i> Nomor Telepon/WA</label>
									<input type="asd" name="phone" id="phone" placeholder="Masukan nomor telepon atau wa" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Nomor telelpon atau wa harus diisi')" oninput="setCustomValidity('')" value="<?= $rowFeedbackUser["phone"]; ?>">
								</div>
								<div class="col-sm-6">
									<label for="email"><i class="fa fa-envelope"></i> Alamat Email</label>
									<input type="email" name="email" id="email" placeholder="your@mail.com" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Alamat email harus diisi')" oninput="setCustomValidity('')" value="<?= $rowFeedbackUser["email"]; ?>">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
									<label for="description"><i class="fa fa-file-text-alt"></i> Deskripsi masukan</label>
									<textarea name="description" id="description" required oninvalid="this.setCustomValidity('Nomor telelpon atau wa harus diisi')" oninput="setCustomValidity('')" class="form-control form-control-user" placeholder="Terimakasih..."><?= $rowFeedbackUser["description"]; ?></textarea>
								</div>
							</div>
							<div class="form-group row form-group-feedback">
								<div class="col-6 col-sm-2">
									<label class="imagecheck mb-3">
										<input name="response" type="radio" value="Sangat Baik" class="imagecheck-input" <?php if ($rowFeedbackUser["response"] === "Sangat Baik") : ?>checked="" <?php endif; ?>>
										<figure class="imagecheck-figure">
											<img src="<?php include("url.php"); ?>assets/img/feedback/happy.png" alt="title" class="imagecheck-image">
										</figure>
									</label>
								</div>

								<div class="col-6 col-sm-2">
									<label class="imagecheck mb-3">
										<input name="response" type="radio" value="Baik" class="imagecheck-input" <?php if ($rowFeedbackUser["response"] === "Baik") : ?>checked="" <?php endif; ?>>
										<figure class="imagecheck-figure">
											<img src="<?php include("url.php"); ?>assets/img/feedback/smile.png" alt="title" class="imagecheck-image">
										</figure>
									</label>
								</div>

								<div class="col-6 col-sm-2">
									<label class="imagecheck mb-3">
										<input name="response" type="radio" value="Sedang" class="imagecheck-input" <?php if ($rowFeedbackUser["response"] === "Sedang") : ?>checked="" <?php endif; ?>>
										<figure class="imagecheck-figure">
											<img src="<?php include("url.php"); ?>assets/img/feedback/confused.png" alt="title" class="imagecheck-image">
										</figure>
									</label>
								</div>

								<div class="col-6 col-sm-2">
									<label class="imagecheck mb-3">
										<input name="response" type="radio" value="Buruk" class="imagecheck-input" <?php if ($rowFeedbackUser["response"] === "Buruk") : ?>checked="" <?php endif; ?>>
										<figure class="imagecheck-figure">
											<img src="<?php include("url.php"); ?>assets/img/feedback/sad1.png" alt="title" class="imagecheck-image">
										</figure>
									</label>
								</div>

								<div class="col-6 col-sm-2">
									<label class="imagecheck mb-3">
										<input name="response" type="radio" value="Sangat Buruk" class="imagecheck-input" <?php if ($rowFeedbackUser["response"] === "Sangat Buruk") : ?>checked="" <?php endif; ?>>
										<figure class="imagecheck-figure">
											<img src="<?php include("url.php"); ?>assets/img/feedback/sad2.png" alt="title" class="imagecheck-image">
										</figure>
									</label>
								</div>

								<input type="text" hidden name="date" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowFeedbackUser["date"]))))))))); ?>">
								<input type="text" hidden name="time" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowFeedbackUser["time"]))))))))); ?>">
								<input type="text" hidden name="status" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowFeedbackUser["status"]))))))))); ?>">
								<input type="text" hidden name="status_all" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($readAllFeeadbackUser))))))))); ?>">
								<input type="text" hidden name="status_update" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($statusUpdateFeedbackUser1))))))))); ?>">
							</div>
					</div>
					<div class="modal-footer">
						<p>Catatan : Kamu hanya mempunyai 1 kesempatan untuk mengubah feedbackmu</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" name="update_feedback" class="btn btn-primary">Ubah Feedback</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>


<?php if ($rowFeedbackUser["status_update"] === "1") : ?>
	<?php if (!empty($rowFeedbackUser)) : ?>
		<!-- Modal Update Feedback -->
		<div class="modal fade" id="feedBack" tabindex="-1" role="dialog" aria-labelledby="feedBack" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Feedback kamu</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="" method="post">
							<div class="form-group row">
								<div class="col-sm-6">
									<label for="phone"><i class="fa fa-mobile-alt"></i> Nomor Telepon/WA</label>
									<input type="number" name="phone" id="phone" placeholder="Masukan nomor telepon atau wa" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Nomor telelpon atau wa harus diisi')" oninput="setCustomValidity('')" value="<?= $rowFeedbackUser["phone"]; ?>" disabled>
								</div>
								<div class="col-sm-6">
									<label for="email"><i class="fa fa-envelope"></i> Alamat Email</label>
									<input type="email" name="email" id="email" placeholder="your@mail.com" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Alamat email harus diisi')" oninput="setCustomValidity('')" value="<?= $rowFeedbackUser["email"]; ?>" disabled>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
									<label for="description"><i class="fa fa-file-text-alt"></i> Deskripsi masukan</label>
									<textarea name="description" id="description" required oninvalid="this.setCustomValidity('Nomor telelpon atau wa harus diisi')" oninput="setCustomValidity('')" class="form-control form-control-user" placeholder="Terimakasih..." disabled><?= $rowFeedbackUser["description"]; ?></textarea>
								</div>
							</div>
							<div class="form-group row form-group-feedback">
								<div class="col-6 col-sm-2">
									<label class="imagecheck mb-3">
										<input name="response" type="radio" disabled value="Sangat Baik" class="imagecheck-input" <?php if ($rowFeedbackUser["response"] === "Sangat Baik") : ?>checked="" <?php endif; ?>>
										<figure <?php if ($rowFeedbackUser["response"] === "Sangat Baik") : ?>class="imagecheck-figure" <?php endif; ?>>
											<img src="<?php include("url.php"); ?>assets/img/feedback/happy.png" alt="title" class="imagecheck-image">
										</figure>
									</label>
								</div>

								<div class="col-6 col-sm-2">
									<label class="imagecheck mb-3">
										<input name="response" type="radio" disabled value="Baik" class="imagecheck-input" <?php if ($rowFeedbackUser["response"] === "Baik") : ?>checked="" <?php endif; ?>>
										<figure <?php if ($rowFeedbackUser["response"] === "Baik") : ?>class="imagecheck-figure" <?php endif; ?>>
											<img src="<?php include("url.php"); ?>assets/img/feedback/smile.png" alt="title" class="imagecheck-image">
										</figure>
									</label>
								</div>

								<div class="col-6 col-sm-2">
									<label class="imagecheck mb-3">
										<input name="response" type="radio" disabled value="Sedang" class="imagecheck-input" <?php if ($rowFeedbackUser["response"] === "Sedang") : ?>checked="" <?php endif; ?>>
										<figure <?php if ($rowFeedbackUser["response"] === "Sedang") : ?>class="imagecheck-figure" <?php endif; ?>>
											<img src="<?php include("url.php"); ?>assets/img/feedback/confused.png" alt="title" class="imagecheck-image">
										</figure>
									</label>
								</div>

								<div class="col-6 col-sm-2">
									<label class="imagecheck mb-3">
										<input name="response" type="radio" disabled value="Buruk" class="imagecheck-input" <?php if ($rowFeedbackUser["response"] === "Buruk") : ?>checked="" <?php endif; ?>>
										<figure <?php if ($rowFeedbackUser["response"] === "Buruk") : ?>class="imagecheck-figure" <?php endif; ?>>
											<img src="<?php include("url.php"); ?>assets/img/feedback/sad1.png" alt="title" class="imagecheck-image">
										</figure>
									</label>
								</div>

								<div class="col-6 col-sm-2">
									<label class="imagecheck mb-3">
										<input name="response" type="radio" disabled value="Sangat Buruk" class="imagecheck-input" <?php if ($rowFeedbackUser["response"] === "Sangat Buruk") : ?>checked="" <?php endif; ?>>
										<figure <?php if ($rowFeedbackUser["response"] === "Sangat Buruk") : ?>class="imagecheck-figure" <?php endif; ?>>
											<img src="<?php include("url.php"); ?>assets/img/feedback/sad2.png" alt="title" class="imagecheck-image">
										</figure>
									</label>
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>