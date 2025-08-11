 <div class="modal-window create-user-modal">
    <!-- create user form -->
    <form class="create-user-form custom-form">
        <div class="form-title bg-blue">
            <p>Create User</p>
        </div>
        <label class="form-label" for="username">Username:</label>
        <input class="form-control" type="text" id="username" name="username" autocomplete="off">
        <label class="form-label" for="create-photo">Photo:</label>
        <input class="form-control" type="file" id="create-photo" name="photo" accept="image/*">
        <label class="form-label" for="password">Password:</label>
        <input class="form-control" type="password" id="password" name="password">
        <div class="form-btn-container">
            <a class="btn bg-black form-back-btn">Back</a>
            <input class="btn bg-blue form-create-btn" type="submit" name="submit" value="Create User">
        </div>
    </form> 
    <!-- end of create user form -->
</div>