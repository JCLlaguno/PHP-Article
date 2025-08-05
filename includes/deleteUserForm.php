<!-- DELETE modal -->
<div class="modal-window delete-modal">
    <form class="delete-modal-form delete-user-form">
        <input id="delete-id" name="delete-id" type="hidden">
        <p class="modal-title">Delete this <?php echo ($_GET['page'] === 'articles') ? 'article' : 'user'; ?>?</p> 
        <div class="modal-confirm">
            <input class="bg-green btn modal-cancel-btn" type="button" value="No">
            <input class="bg-red btn modal-confirm-btn" type="submit" value="Yes">
        </div>
    </form>
</div>
<!-- end of DELETE modal -->