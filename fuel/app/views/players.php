<h2>Players</h2>

<a id="backButton" class="headerButton" href="/"><i class="icon-left-open"></i></a>

<a class="headerButton" href="/players/add"><i class="icon-plus"></i></a>

<ul id="playerList" class="playerList">

    <? foreach($players as $Player) { ?>

        <li data-player-id="<?=$Player->id?>">

            <a href="/players/edit/<?=$Player->id?>">

                <div class="iconWrapper">
                    <i class="icon-user"></i>
                </div>

                <div class="nameWrapper">
                    <div class="name"><?=$Player->firstname.' '.$Player->lastname?></div>
                </div>

            </a>

        </li>

    <? } ?>

</ul>

<script>

    $(function()
    {

    });

</script>

