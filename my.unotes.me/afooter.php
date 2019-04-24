		<!-- Sticky Footer on every page -->
        <footer class="footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>&copy; UNotes <?php echo date("Y") ?>. All rights reserved. </span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->	
	
	<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
						
	<!-- Create note Modal-->
    <div class="modal fade" id="newnoteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
	   <form action="edit.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Create new note</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
			<div class="row">
				<div class="col-xl-7 form-group">
					<small id="emailHelp" class="form-text">Note Title</small>
					<input type="text" class="form-control" name="note_title" placeholder="Example: Shopping list #243">
				</div>
				<div class="col-xl-5 form-group">
					<small id="emailHelp" class="form-text">Save to notebook</small>
					<select class="form-control" name="note_notebook">
						<option value="" selected>None</option>
							<?php include '_inc/dbconn.php';
								$sql="SELECT * FROM UNotesDAT.notebook".$account_id;
								$result=  mysql_query($sql) or die(mysql_error());
								$num_rows = mysql_num_rows($result);

								while($rws=  mysql_fetch_array($result)){
									// displaying notebooks
									echo "<option value='".$rws[0]."'>".$rws[1]." (".strtolower($rws[2]).")</option>";
								} 
							?>
					</select>
				</div>
			</div>
			<small class="form-text">Note content</small>
			<textarea class="form-control" name="note_content" rows="3" placeholder="1 avocado, 2 bread, eggs, ..."></textarea>
      <small class="form-text"><input type="checkbox" name="note_bookmark" value="1"> Bookmark Note? (This will pin your note at the top of the notes page.)</small>
		  </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Discard</button>
            <button type="submit" class="btn btn-success icon save" name="note_create"><i class="fas fa-save"></i> Save note</button>
          </div>
        </div>
	   </form>
      </div>
    </div>
	
	<!-- Go Premium Modal-->
    <div class="modal fade" id="premiumModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Want to go <i class="far fa-gem"></i> Premium?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">With UNotes premium you can enjoy a lot of new features, like:<br><br>
            <ul>
              <li><i class="fas fa-share-square"></i> <b>Note sharing</b> - lets you share your notes with other users to maximize work efficiency. Both users can view the same note and edit it.</li>
              <li><i class="fas fa-folder-open"></i> <b>Unlimited Notebooks</b> - create as much notebooks as you need/want without a limit!</li>
              <li><i class="fas fa-crown"></i> <b>Premium crown</b> - you will get a crown next to your name to let other users know that you support UNotes!</li>
            </ul>
            And even more features! Go to <a href="http://unotes.me/premium" target="_blank">unotes.me/premium</a> for more information or use the button below to go there.
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="http://unotes.me/premium" target="_blank">Go <i class="far fa-gem"></i> Premium &raquo;</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-fw fa-sign-out-alt"></i> Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout">Logout <i class="fas fa-fw fa-sign-out-alt"></i></a>
          </div>
        </div>
      </div>
    </div>

    <!-- Credits footer on every page -->
    <div style="position: fixed;bottom: 0;right: 15px;background-color: #f2f2f2;box-shadow: 0 4px 8px rgba(0,0,0,.05);border-radius: 3px 3px 0 0;font-size: 12px;padding: 5px 10px;">Created by <a href="https://github.com/Tonemon" target="blank">Tonemon</a>.</div>

	<!-- Bootstrap core JavaScript-->
    <script src="vendor/js/jquery.min.js"></script>
    <script src="vendor/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/js/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/js/chart.js/Chart.min.js"></script>
    <script src="vendor/js/datatables/jquery.dataTables.js"></script>
    <script src="vendor/js/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="vendor/js/sb-admin.min.js"></script>
	<script src="vendor/js/scroll.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="vendor/js/demo/datatables-demo.js"></script>
    <script src="vendor/js/demo/chart-area-demo.js"></script>
  </body>
</html>