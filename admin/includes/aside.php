<aside id="sidebar" class="js-sidebar">
    <!-- Content For Sidebar -->
    <div class="h-100">
        <div class="sidebar-logo text-center">
            <img src="../img/admin-img/majayjay-logo.webp" alt="logo" height="150px" width="150px">
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Admin Elements
            </li>
            <li class="sidebar-item">
                <a href="../admin/dashboard.php" class="sidebar-link">
                    <i class="fa-solid fa-list"></i>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#website" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="bi bi-gear"></i>
                    Manage Website Contents
                </a>
                <ul id="website" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="../admin/manage-website-frontpage.php" class="sidebar-link">Front Page</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../admin/contact-page.php" class="sidebar-link">Contact Info Page</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../admin/about-page.php" class="sidebar-link">About Us Page</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#post" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fa-solid fa-file-lines pe-1"></i>
                    Post Announcements
                </a>
                <ul id="post" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Post</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="../admin/manage-business-account.php" class="sidebar-link collapsed" data-bs-target="#brgyacc" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="bi bi-building-gear"></i>
                    Manage Business Accounts
                </a>
                <ul id="brgyacc" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="../../admin/add-barangay-account.php" class="sidebar-link">Add Barangay Accounts</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../admin/view-barangay-accounts.php" class="sidebar-link">
                            <i class="bi bi-list"></i>
                            View Barangay Accounts
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="../admin/add-business-type.php" class="sidebar-link">
                    <i class="bi bi-plus-circle-fill"></i>
                    Add Business Types
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../admin/manage-tourist-account.php" class="sidebar-link">
                    <i class="bi bi-person-fill-gear"></i>
                    Manage Tourist Accounts
                </a>
            </li>
        </ul>
    </div>
</aside>