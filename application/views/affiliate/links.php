<?php $this->load->view('layouts/header', ['title' => 'Affiliate Links']); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 sidebar">
            <h4 class="text-center mb-4"><i class="fas fa-link"></i> Links</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('affiliate/dashboard'); ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo base_url('affiliate/links'); ?>">
                        <i class="fas fa-link"></i> Affiliate Links
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-link"></i> Your Affiliate Links</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Landing Page Link</label>
                        <div class="input-group">
                            <input type="text" id="profileLink" class="form-control" value="<?php echo $profile_link; ?>" readonly>
                            <button class="btn btn-primary" onclick="copyLink('profileLink')">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                        <small class="text-muted">Your unique landing page: <strong><?php echo $affiliate->slug; ?></strong></small>
                        <p class="text-info mt-2"><i class="fas fa-info-circle"></i> Share this link to track clicks and capture leads</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Signup Link</label>
                        <div class="input-group">
                            <input type="text" id="signupLink" class="form-control" value="<?php echo $signup_link; ?>" readonly>
                            <button class="btn btn-primary" onclick="copyLink('signupLink')">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                        <small class="text-muted">Share this link for new affiliate signups</small>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="fas fa-tag"></i> Generate Discount Link</h5>
                        
                        <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>
                        
                        <form id="discountLinkForm" method="POST" action="<?php echo base_url('affiliate/generate_discount_link'); ?>">
                            <div class="row">
                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label fw-bold">Discount Percentage (%)</label>
                                    <input type="number" name="discount_percent" id="discount_percent" class="form-control" 
                                           min="<?php echo isset($discount_min) ? $discount_min : 0; ?>" 
                                           max="<?php echo isset($discount_max) ? $discount_max : 50; ?>" 
                                           step="0.1" required>
                                    <small class="form-text text-muted">
                                        Enter discount between <?php echo isset($discount_min) ? $discount_min : 0; ?>% and <?php echo isset($discount_max) ? $discount_max : 50; ?>%
                                    </small>
                                </div>
                                <div class="col-md-6 col-12 mb-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-link"></i> Generate Discount Link
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <?php if (isset($generated_discount_link) && !empty($generated_discount_link)): ?>
                        <div class="alert alert-success mt-3">
                            <label class="form-label fw-bold">Generated Discount Link:</label>
                            <div class="input-group">
                                <input type="text" id="discountLink" class="form-control" value="<?php echo htmlspecialchars($generated_discount_link); ?>" readonly>
                                <button class="btn btn-primary" onclick="copyLink('discountLink')">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                            <small class="text-muted mt-2 d-block">This link includes a <?php echo htmlspecialchars($discount_percent); ?>% discount</small>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> <strong>Tips:</strong> Share these links on your website, social media, or email campaigns to earn commissions.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyLink(inputId) {
    const input = document.getElementById(inputId);
    input.select();
    input.setSelectionRange(0, 99999);
    document.execCommand('copy');
    alert('Link copied to clipboard!');
}
</script>

<?php $this->load->view('layouts/footer'); ?>

