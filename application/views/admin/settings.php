<?php $this->load->view('layouts/header', ['title' => 'Settings']); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 sidebar">
            <h4 class="text-center mb-4"><i class="fas fa-shield-alt"></i> Admin</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('admin/dashboard'); ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('admin/affiliates'); ?>">
                        <i class="fas fa-users"></i> Affiliates
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('admin/leads'); ?>">
                        <i class="fas fa-list"></i> Leads
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('admin/commissions'); ?>">
                        <i class="fas fa-dollar-sign"></i> Commissions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo base_url('admin/settings'); ?>">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('admin/change_password'); ?>">
                        <i class="fas fa-key"></i> Change Password
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('admin/logout'); ?>">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="col-md-9">
            <h2 class="mb-4"><i class="fas fa-cog"></i> Settings</h2>
            
            <?php if (isset($table_exists) && !$table_exists): ?>
            <div class="alert alert-warning">
                <h5><i class="fas fa-exclamation-triangle"></i> Settings Table Not Found</h5>
                <p>The settings table does not exist in the database. Please run the table creation script:</p>
                <ol>
                    <li>Open your browser and go to: <code><?php echo base_url('create_settings_table.php'); ?></code></li>
                    <li>Or run it via command line: <code>php create_settings_table.php</code></li>
                </ol>
                <p class="mb-0">Once the table is created, refresh this page.</p>
            </div>
            <?php endif; ?>
            
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo ($active_tab == 'general') ? 'active' : ''; ?>" 
                            id="general-tab" data-bs-toggle="tab" data-bs-target="#general" 
                            type="button" role="tab" aria-controls="general" aria-selected="<?php echo ($active_tab == 'general') ? 'true' : 'false'; ?>">
                        <i class="fas fa-info-circle"></i> General
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo ($active_tab == 'homepage') ? 'active' : ''; ?>" 
                            id="homepage-tab" data-bs-toggle="tab" data-bs-target="#homepage" 
                            type="button" role="tab" aria-controls="homepage" aria-selected="<?php echo ($active_tab == 'homepage') ? 'true' : 'false'; ?>">
                        <i class="fas fa-home"></i> Homepage
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo ($active_tab == 'contact') ? 'active' : ''; ?>" 
                            id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" 
                            type="button" role="tab" aria-controls="contact" aria-selected="<?php echo ($active_tab == 'contact') ? 'true' : 'false'; ?>">
                        <i class="fas fa-phone"></i> Contact
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo ($active_tab == 'social') ? 'active' : ''; ?>" 
                            id="social-tab" data-bs-toggle="tab" data-bs-target="#social" 
                            type="button" role="tab" aria-controls="social" aria-selected="<?php echo ($active_tab == 'social') ? 'true' : 'false'; ?>">
                        <i class="fas fa-share-alt"></i> Social Media
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo ($active_tab == 'footer') ? 'active' : ''; ?>" 
                            id="footer-tab" data-bs-toggle="tab" data-bs-target="#footer" 
                            type="button" role="tab" aria-controls="footer" aria-selected="<?php echo ($active_tab == 'footer') ? 'true' : 'false'; ?>">
                        <i class="fas fa-window-minimize"></i> Footer
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo ($active_tab == 'commission') ? 'active' : ''; ?>" 
                            id="commission-tab" data-bs-toggle="tab" data-bs-target="#commission" 
                            type="button" role="tab" aria-controls="commission" aria-selected="<?php echo ($active_tab == 'commission') ? 'true' : 'false'; ?>">
                        <i class="fas fa-percent"></i> Commission
                    </button>
                </li>
            </ul>
            
            <!-- Tabs Content -->
            <div class="tab-content" id="settingsTabsContent">
                
                <!-- General Settings Tab -->
                <div class="tab-pane fade <?php echo ($active_tab == 'general') ? 'show active' : ''; ?>" 
                     id="general" role="tabpanel" aria-labelledby="general-tab">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> General Settings</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo base_url('admin/settings?tab=general'); ?>">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Site Name</label>
                                        <input type="text" name="site_name" class="form-control" 
                                               value="<?php echo isset($settings['site_name']) ? htmlspecialchars($settings['site_name']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Site Tagline</label>
                                        <input type="text" name="site_tagline" class="form-control" 
                                               value="<?php echo isset($settings['site_tagline']) ? htmlspecialchars($settings['site_tagline']) : ''; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Site Email</label>
                                        <input type="email" name="site_email" class="form-control" 
                                               value="<?php echo isset($settings['site_email']) ? htmlspecialchars($settings['site_email']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Site Phone</label>
                                        <input type="text" name="site_phone" class="form-control" 
                                               value="<?php echo isset($settings['site_phone']) ? htmlspecialchars($settings['site_phone']) : ''; ?>">
                                    </div>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save General Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Homepage Settings Tab -->
                <div class="tab-pane fade <?php echo ($active_tab == 'homepage') ? 'show active' : ''; ?>" 
                     id="homepage" role="tabpanel" aria-labelledby="homepage-tab">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-home"></i> Homepage Settings</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo base_url('admin/settings?tab=homepage'); ?>">
                                <div class="mb-3">
                                    <label class="form-label">Hero Section Title</label>
                                    <input type="text" name="hero_title" class="form-control" 
                                           value="<?php echo isset($settings['hero_title']) ? htmlspecialchars($settings['hero_title']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hero Section Subtitle</label>
                                    <textarea name="hero_subtitle" class="form-control" rows="3"><?php echo isset($settings['hero_subtitle']) ? htmlspecialchars($settings['hero_subtitle']) : ''; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hero Background Image URL</label>
                                    <input type="url" name="hero_image" class="form-control" 
                                           value="<?php echo isset($settings['hero_image']) ? htmlspecialchars($settings['hero_image']) : ''; ?>">
                                </div>
                                <hr>
                                <h6>About Section</h6>
                                <div class="mb-3">
                                    <label class="form-label">About Section Title</label>
                                    <input type="text" name="about_title" class="form-control" 
                                           value="<?php echo isset($settings['about_title']) ? htmlspecialchars($settings['about_title']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">About Section Description</label>
                                    <textarea name="about_description" class="form-control" rows="4"><?php echo isset($settings['about_description']) ? htmlspecialchars($settings['about_description']) : ''; ?></textarea>
                                </div>
                                <hr>
                                <h6>Statistics</h6>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Happy Affiliates</label>
                                        <input type="text" name="stat_affiliates" class="form-control" 
                                               value="<?php echo isset($settings['stat_affiliates']) ? htmlspecialchars($settings['stat_affiliates']) : ''; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Online Referrals</label>
                                        <input type="text" name="stat_referrals" class="form-control" 
                                               value="<?php echo isset($settings['stat_referrals']) ? htmlspecialchars($settings['stat_referrals']) : ''; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Years of Experience</label>
                                        <input type="text" name="stat_experience" class="form-control" 
                                               value="<?php echo isset($settings['stat_experience']) ? htmlspecialchars($settings['stat_experience']) : ''; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Team Members</label>
                                        <input type="text" name="stat_team" class="form-control" 
                                               value="<?php echo isset($settings['stat_team']) ? htmlspecialchars($settings['stat_team']) : ''; ?>">
                                    </div>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Homepage Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Settings Tab -->
                <div class="tab-pane fade <?php echo ($active_tab == 'contact') ? 'show active' : ''; ?>" 
                     id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-phone"></i> Contact Settings</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo base_url('admin/settings?tab=contact'); ?>">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Contact Phone</label>
                                        <input type="text" name="contact_phone" class="form-control" 
                                               value="<?php echo isset($settings['contact_phone']) ? htmlspecialchars($settings['contact_phone']) : ''; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Contact Email</label>
                                        <input type="email" name="contact_email" class="form-control" 
                                               value="<?php echo isset($settings['contact_email']) ? htmlspecialchars($settings['contact_email']) : ''; ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contact Address</label>
                                    <textarea name="contact_address" class="form-control" rows="2"><?php echo isset($settings['contact_address']) ? htmlspecialchars($settings['contact_address']) : ''; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Working Hours</label>
                                    <input type="text" name="working_hours" class="form-control" 
                                           value="<?php echo isset($settings['working_hours']) ? htmlspecialchars($settings['working_hours']) : ''; ?>">
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Contact Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Settings Tab -->
                <div class="tab-pane fade <?php echo ($active_tab == 'social') ? 'show active' : ''; ?>" 
                     id="social" role="tabpanel" aria-labelledby="social-tab">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-share-alt"></i> Social Media Settings</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo base_url('admin/settings?tab=social'); ?>">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><i class="fab fa-facebook"></i> Facebook URL</label>
                                        <input type="url" name="social_facebook" class="form-control" 
                                               value="<?php echo isset($settings['social_facebook']) ? htmlspecialchars($settings['social_facebook']) : ''; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><i class="fab fa-twitter"></i> Twitter URL</label>
                                        <input type="url" name="social_twitter" class="form-control" 
                                               value="<?php echo isset($settings['social_twitter']) ? htmlspecialchars($settings['social_twitter']) : ''; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><i class="fab fa-instagram"></i> Instagram URL</label>
                                        <input type="url" name="social_instagram" class="form-control" 
                                               value="<?php echo isset($settings['social_instagram']) ? htmlspecialchars($settings['social_instagram']) : ''; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><i class="fab fa-linkedin"></i> LinkedIn URL</label>
                                        <input type="url" name="social_linkedin" class="form-control" 
                                               value="<?php echo isset($settings['social_linkedin']) ? htmlspecialchars($settings['social_linkedin']) : ''; ?>">
                                    </div>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Social Media Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Footer Settings Tab -->
                <div class="tab-pane fade <?php echo ($active_tab == 'footer') ? 'show active' : ''; ?>" 
                     id="footer" role="tabpanel" aria-labelledby="footer-tab">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-window-minimize"></i> Footer Settings</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo base_url('admin/settings?tab=footer'); ?>">
                                <div class="mb-3">
                                    <label class="form-label">Footer Description</label>
                                    <textarea name="footer_text" class="form-control" rows="3"><?php echo isset($settings['footer_text']) ? htmlspecialchars($settings['footer_text']) : ''; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Copyright Text</label>
                                    <input type="text" name="footer_copyright" class="form-control" 
                                           value="<?php echo isset($settings['footer_copyright']) ? htmlspecialchars($settings['footer_copyright']) : ''; ?>">
                                    <small class="form-text text-muted">Use {year} to display current year automatically</small>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Footer Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Commission Settings Tab -->
                <div class="tab-pane fade <?php echo ($active_tab == 'commission') ? 'show active' : ''; ?>" 
                     id="commission" role="tabpanel" aria-labelledby="commission-tab">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-percent"></i> Commission Settings</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo base_url('admin/settings?tab=commission'); ?>">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Default Commission Rate (%)</label>
                                        <input type="number" name="commission_rate" class="form-control" 
                                               value="<?php echo isset($settings['commission_rate']) ? htmlspecialchars($settings['commission_rate']) : '22'; ?>" 
                                               min="0" max="100" step="0.1">
                                        <small class="form-text text-muted">Default commission percentage for affiliates</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Minimum Payout Amount</label>
                                        <input type="number" name="min_payout" class="form-control" 
                                               value="<?php echo isset($settings['min_payout']) ? htmlspecialchars($settings['min_payout']) : '50'; ?>" 
                                               min="0" step="0.01">
                                        <small class="form-text text-muted">Minimum amount required for payout</small>
                                    </div>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Commission Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Handle tab switching with URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    if (tab) {
        const tabElement = document.getElementById(tab + '-tab');
        if (tabElement) {
            const tabTrigger = new bootstrap.Tab(tabElement);
            tabTrigger.show();
        }
    }
</script>

<?php $this->load->view('layouts/footer'); ?>

