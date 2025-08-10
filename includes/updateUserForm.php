<div class="modal-window update-user-modal">
    <!-- update user form -->
    <form class="custom-form update-user-form">
        <div class="form-title bg-green">
            <p>Update User</p>
        </div>
        <label class="form-label" for="update-user-username">Username:</label>
        <input class="form-control username" type="text" id="update-user-username" name="username" autocomplete="off">
        <label class="form-label" for="update-photo">Photo:</label>
        <input class="form-control update-photo" type="file" id="update-photo" name="photo" accept="image/*" title="">
        <label class="form-label" for="new-password">New Password:</label>
        <input class="form-control" type="password" id="new-password" name="new-password">
        <input id="update-user-id" name="update-user-id" type="hidden">
        <div class="form-btn-container">
            <a class="btn bg-black form-back-btn">Back</a>
            <input class="btn bg-green form-update-btn" type="submit" name="submit" value="Update user">
        </div>
    </form> 
    <!-- end of update user form -->
</div>
<!-- end of update user section -->