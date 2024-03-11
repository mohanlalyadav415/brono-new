<?php $__env->startSection('title'); ?>
<?php echo app('translator')->get('translation.password-reset'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 0 1440 120">
            <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
        </svg>
    </div>
</div>



<!-- auth page content -->
<div class="auth-page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mt-sm-5 mb-4 text-white-50">
                    <div>
                        <a href="index" class="d-inline-block auth-logo">
                            <img src="<?php echo e(URL::asset('build/images/logo-light.png')); ?>" alt=""
                            height="100%" width="100%" style="max-width: 120px;">
                        </a>
                    </div> 
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">

                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Forgot Password?</h5>
                            <p class="text-muted">Reset password with ATGO</p>

                            <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                            colors="primary:#0ab39c" class="avatar-xl">
                        </lord-icon>

                    </div>
                    <?php if(session('success_msg')): ?> 
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo e(session('success_msg')); ?>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div> 
                    <?php endif; ?>
                    <div class="p-2">
                        <form class="form-horizontal" method="POST" action="<?php echo e(url('/')); ?>/reset-password/<?php echo e($token); ?> ?>">
                            <?php echo csrf_field(); ?> 
                            <div class="mb-3">
                                <label for="userpassword">Password</label>
                                <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" id="userpassword" placeholder="Enter password"> 
                                <span style="color: red;"><?php if($errors->has('password')): ?>
                                    <?php echo e($errors->first('password')); ?> 
                                    <?php endif; ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="userpassword">Confirm Password</label>
                                <input id="password-confirm" type="password" name="password_confirmation" class="form-control" placeholder="Enter confirm password">
                                <p>Minimum 8 characters, with a symbol a CAP and a number</p>
                            </div>

                            <div class="text-end">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Change Password</button>
                            </div>

                        </form><!-- end form -->
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">
                <p class="mb-0">Wait, I remember my password... <a href="auth-signin-basic"
                    class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                </div>

            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end auth page content -->

<!-- footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> Crafted with <i
                    class="mdi mdi-heart text-danger"></i> by ATGO</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/particles.js/particles.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/particles.app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/auth/passwords/reset.blade.php ENDPATH**/ ?>