<h2>Select players</h2>

<a id="backButton" class="headerButton" href="/"><i class="icon-left-open"></i></a>

<ul id="selectGroup" class="playerList">

    <? foreach($players as $Player) { ?>

        <li data-player-id="<?=$Player->id?>">

            <div class="iconWrapper">
                <i class="icon-user"></i>
            </div>

            <div class="nameWrapper">
                <div class="name"><?=$Player->firstname.' '.$Player->lastname?></div>
            </div>

        </li>

    <? } ?>

</ul>

<h2>Select event</h2>

<div class="radioWrapper">
    <input type="radio" id="golf" name="eventType" value="1" checked>
    <label for="golf">Golf</label>
</div>

<div class="radioWrapper">
    <input type="radio" id="discgolf" name="eventType" value="2">
    <label for="discgolf">Discgolf</label>
</div>

<div class="radioWrapper">
    <input type="radio" id="minigolf" name="eventType" value="3">
    <label for="minigolf">Minigolf</label>
</div>

<br/>
<br/>
<br/>

<a href="#" id="createGroupButton" class="button last" type="button"><i class="icon-users"></i> Create group</a>


<script>

    $(function()
    {
        $('#createGroupButton').on('click', function()
        {
            var selected = [];
            $('#selectGroup').find('li.selected').each(function()
            {
                selected.push($(this).data('player-id'));
            });

            localStorage.setItem('activeGroup', JSON.stringify(selected));
            localStorage.setItem('activeCategory', $('input[name="eventType"]:checked').val());
            localStorage.removeItem('activeHole');

            location.href = '/scorecard';

            return false;
        });

        $('#selectGroup').on('click', 'li', function()
        {
            var $li = $(this);

            if($li.hasClass('selected'))
            {
                $li .removeClass('selected')
                    .find('i').removeClass().addClass('icon-user');
            }
            else
            {
                $li .addClass('selected')
                    .find('i').removeClass().addClass('icon-check');
            }

        });

    })

</script>

