<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/all.min.css'; ?>">

<?php if($language_dir == 'rtl'): ?>
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/bootstrap.rtl.min.css'; ?>">
<?php else: ?>
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/bootstrap.min.css'; ?>">
<?php endif; ?>


<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/jquery.webui-popover.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/h-2-carousel.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/jquery.webui-popover.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/nice-select.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/owl.carousel.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/owl.theme.default.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/slick-theme.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/slick.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/style.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/new-style.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/responsive.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/summernote-0.8.20-dist/summernote-lite.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/global/tagify/tagify.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/global/toastr/toastr.css' ?>">

<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/custom.css'; ?>">

<?php if($language_dir == 'rtl'): ?>
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default-new/css/rtl.css'; ?>">
<?php endif; ?>

<script src="<?php echo base_url('assets/global/js/jquery-3.6.1.min.js'); ?>"></script>
<style>

  
.fcp-box{
  

  width: auto;
  height: auto;
  max-width: 300px;
  max-height: 500px;
  padding: 5px;
  margin-top: 10px;
  margin-right: 10px;

  

}
.fcp-box  a {
    width: 100%;
    height: 100%;
  position: relative;
  display: inline-block;
  padding: 10px 20px;
  color: #03e9f4;
  font-size: 16px;
  text-decoration: none;
  text-transform: uppercase;
  overflow: hidden;
  transition: .5s;
  letter-spacing: 4px;
  background: rgba(0,0,0,.5);
  box-sizing: border-box;
  box-shadow: 0 15px 25px rgba(0,0,0,.6);
  border-radius: 10px;
}
.fcp-box a:hover {
  background: #03e9f4;
  color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 5px #03e9f4,
              0 0 25px #03e9f4,
              0 0 50px #03e9f4,
              0 0 100px #03e9f4;
}

.fcp-box a span {
  position: absolute;
  display: block;
}

.fcp-box a span:nth-child(1) {
  top: 0;
  left: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, #03e9f4);
  animation: btn-anim1 1s linear infinite;
}

.fcp-box a span:nth-child(2) {
  top: -100%;
  right: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(180deg, transparent, #03e9f4);
  animation: btn-anim2 1s linear infinite;
  animation-delay: .25s
}



.fcp-box a span:nth-child(3) {
  bottom: 0;
  right: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(270deg, transparent, #03e9f4);
  animation: btn-anim3 1s linear infinite;
  animation-delay: .5s
}


.fcp-box a span:nth-child(4) {
  bottom: -100%;
  left: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(360deg, transparent, #03e9f4);
  animation: btn-anim4 1s linear infinite;
  animation-delay: .75s
}


.login-box {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 400px;
  padding: 40px;
  transform: translate(-50%, -50%);
  background: rgba(0,0,0,.5);
  box-sizing: border-box;
  box-shadow: 0 15px 25px rgba(0,0,0,.6);
  border-radius: 10px;
}

.login-box h2 {
  margin: 0 0 30px;
  padding: 0;
  color: #fff;
  text-align: center;
}

.login-box .user-box {
  position: relative;
}

.login-box .user-box input {
  width: 100%;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  margin-bottom: 30px;
  border: none;
  border-bottom: 1px solid #fff;
  outline: none;
  background: transparent;
}
.login-box .user-box label {
  position: absolute;
  top:0;
  left: 0;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  pointer-events: none;
  transition: .5s;
}

.login-box .user-box input:focus ~ label,
.login-box .user-box input:valid ~ label {
  top: -20px;
  left: 0;
  color: #03e9f4;
  font-size: 12px;
}

.login-box form a {
  position: relative;
  display: inline-block;
  padding: 10px 20px;
  color: #03e9f4;
  font-size: 16px;
  text-decoration: none;
  text-transform: uppercase;
  overflow: hidden;
  transition: .5s;
  margin-top: 40px;
  letter-spacing: 4px
}

.login-box a:hover {
  background: #03e9f4;
  color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 5px #03e9f4,
              0 0 25px #03e9f4,
              0 0 50px #03e9f4,
              0 0 100px #03e9f4;
}

.login-box a span {
  position: absolute;
  display: block;
}

.login-box a span:nth-child(1) {
  top: 0;
  left: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, #03e9f4);
  animation: btn-anim1 1s linear infinite;
}

@keyframes btn-anim1 {
  0% {
    left: -100%;
  }
  50%,100% {
    left: 100%;
  }
}

.login-box a span:nth-child(2) {
  top: -100%;
  right: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(180deg, transparent, #03e9f4);
  animation: btn-anim2 1s linear infinite;
  animation-delay: .25s
}

@keyframes btn-anim2 {
  0% {
    top: -100%;
  }
  50%,100% {
    top: 100%;
  }
}

.login-box a span:nth-child(3) {
  bottom: 0;
  right: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(270deg, transparent, #03e9f4);
  animation: btn-anim3 1s linear infinite;
  animation-delay: .5s
}

@keyframes btn-anim3 {
  0% {
    right: -100%;
  }
  50%,100% {
    right: 100%;
  }
}

.login-box a span:nth-child(4) {
  bottom: -100%;
  left: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(360deg, transparent, #03e9f4);
  animation: btn-anim4 1s linear infinite;
  animation-delay: .75s
}

@keyframes btn-anim4 {
  0% {
    bottom: -100%;
  }
  50%,100% {
    bottom: 100%;
  }
}


</style>
