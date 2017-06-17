<div class="jumbotron">
    <h1>Convert your icons!</h1>
    <p class="lead">
        Choose you icon (1024x1024 minimum recommended) in PNG/JPG/GIF format.
    </p>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="icon" /><br />
        <p class="lead">
            File max size: <b><?php echo MAX_FILE_SIZE_HUMANREADEABLE; ?></b>
        </p>
        <input type="submit" value="Convert" name="submit" class="btn btn-lg btn-success"/>
    </form>
</div>