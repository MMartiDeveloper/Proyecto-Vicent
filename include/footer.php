    </div>

  </div>

</div>
<!-- /.container -->

<div class="container woodbar" id='footer'>
<!-- Footer -->
<footer>
<div class="row">
    <div class="col-lg-12">
        <p>Copyright &copy; Maderas.de <?php echo date("Y"); ?></p>
    </div>
</div>
</footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="<?php echo SCRIPTSPATH; ?>jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo SCRIPTSPATH; ?>bootstrap.min.js"></script>

<script src="<?php echo SCRIPTSPATH; ?>bootstrap.min.js"></script>
<?php if (isset($bottomScripts)): ?>
  <?php foreach ($bottomScripts as $script): ?>
    <script src="<?php echo SCRIPTSPATH . $script; ?>"></script>
  <?php endforeach; ?>
<?php endif; ?>

</body>

</html>
