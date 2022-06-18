<?php
if (isset($_SESSION['status'])) {
?>
    <script>
        swal.fire({
            title: '<?php echo $_SESSION['status']; ?>',
            //text: 'Prueba',
            icon: '<?php echo $_SESSION['status_msg']; ?>',
            button: 'OK',
            confirmButtonColor: '#404040',
        });
    </script>
<?php
    unset($_SESSION['status']);
    unset($_SESSION['status_msg']);
}
?>