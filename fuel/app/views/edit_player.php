
<h2><? echo $Player ? 'Edit player' : 'Create new player' ?></h2>

<a id="backButton" class="headerButton" href="/players"><i class="icon-left-open"></i></a>

<form id="playerEditForm">

    <input type="hidden" name="playerID" value="<?=@$Player->id?>" />

    <label for="firstname">Firstname</label>
    <input type="text" id="firstname" name="firstname" value="<?=@$Player->firstname?>" />

    <label for="lastname">Lastname</label>
    <input type="text" id="lastname" name="lastname" value="<?=@$Player->lastname?>" />

    <label for="slope">Slope</label>
    <input type="number" class="short" id="slope" name="slope" value="<?=@$Player->slope?>" />

</form>

<a id="submit" href="#" class="button">Save</a>

<div id="responseWrapper" class="success"></div>

<script>

    $(function()
    {
        $('#submit').on('click', function()
        {
            $.ajax({
                url: '/api/player',
                data: $('#playerEditForm').serialize(),
                type: 'post',
                dataType: 'json',
                success: function(msg)
                {
                    $('#responseWrapper').html(msg).fadeIn();

                    setTimeout(function()
                    {
                        $('#responseWrapper').fadeOut();
                    }, 1000);
                },
                failure: function(error)
                {
                    alert(error);
                }
            });

            return false;
        });
    });


</script>

