<h2>Leaderboard</h2>

<a id="backButton" class="headerButton" href="#"><i class="icon-left-open"></i></a>

<table id="leaderboard">

    <tr>
        <th>#</th>
        <th class="name">NAME</th>
        <th>THRU</th>
        <th>SCORE</th>
    </tr>
    <?

    $pos = 1;
    $lastHcp = false;
    $lastScr = false;
    $lastPos = $pos;
    foreach($leaderboard as $player)
    {
        if($player['total'])
        {
            if($player['total'] == $lastHcp && $player['scr'] == $lastScr)
            {
                $usePos = '-';
            }
            else
            {
                $usePos = $pos.'.';
            }

            $lastHcp = $player['total'];
            $lastScr = $player['scr'];
            $lastPos = $usePos;

            ?>
            <tr>
                <td class="rank"><?=$usePos?></td>
                <td class="name"><?=$player['firstname'].' '.$player['lastname']?></td>
                <td class="played"><?=$player['played']?></td>
                <td class="score"><?=$player['total']?> <span class="tdMeta">(<?=$player['scr']?>)</span></td>
            </tr>
            <?
            $pos++;
        }
    }

    ?>

</table>