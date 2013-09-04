<h2>Hole: <span id="holeNumber"></span> <span id="holePar" class="headerMeta"></span> <span id="holeHcp" class="headerMeta"></span></h2>

<a id="backButton" class="headerButton" href="/"><i class="icon-left-open"></i></a>

<a id="leaderboardLink" class="headerButton" href="/leaderboard"><i class="icon-award"></i></a>

<ul id="scoreInput" class="playerList">


</ul>

<ul class="hide">

    <li id="scoreTemplate">

        <div class="nameWrapper">
            <div class="name"></div>
        </div>

        <div class="scoreWrapper">
            <div class="score"><span class="total"></span></div>
        </div>

        <div class="inputWrapper">
            <input type="number" class="result" maxlength="1" min="1" max="9" placeholder="0">
        </div>

    </li>

</ul>

<div class="clearfix"></div>

<div id="holeHandler">

    <a href="#" id="prevHoleButton" class=""><i class="icon-left-open"></i><div class="val"></div></a>

    <a href="#" id="nextHoleButton" class=""><div class="val"></div><i class="icon-right-open"></i></a>

</div>

<a id="roundReadyButton" href="#" class="button">Round ready!</a>

<script>

    $(function()
    {
        var group       = JSON.parse(localStorage.getItem('activeGroup'));
        var category    = localStorage.getItem('activeCategory');
        var hole        = parseInt(localStorage.getItem('activeHole'));

        if(!(hole > 0)) localStorage.removeItem('activeHole');

        if(group && category)
        {
            $.ajax({
                url: '/api/hole',
                data: {
                    group: group,
                    category: category,
                    hole: hole ? hole : false
                },
                type: 'get',
                dataType: 'json',
                success: setHoleState
            });
        }
        else
        {
            location.href = "/";
        }

        $('#roundReadyButton').on('click', function()
        {
            localStorage.removeItem('activeGroup');
            localStorage.removeItem('activeHole');
            localStorage.removeItem('activeCategory');

            location.href = "/";
        });

        $('#holeHandler').on('click', '#prevHoleButton', function()
        {
            var hole = parseInt(localStorage.getItem('activeHole'));

            $.ajax({
                url: '/api/hole',
                data: {
                    group: group,
                    category: category,
                    hole: (parseInt(hole)-1)
                },
                type: 'get',
                dataType: 'json',
                success: setHoleState
            });
        });

        $('#holeHandler').on('click', '#nextHoleButton', function()
        {
            var holeData = [];
            $('#scoreInput').find('li').each(function()
            {
                var _$el    = $(this);
                var _id     = _$el.data('player-id');
                var _score  = parseInt(_$el.find('.result').val());
                var _hole   = parseInt(localStorage.getItem('activeHole'));

                if(!(_hole > 0)) localStorage.removeItem('activeHole');

                holeData.push({
                    hole_id: _hole ? _hole : 1,
                    player_id: _id,
                    score: _score ? _score : null
                });

            });

            $.ajax({
                url: '/api/hole/',
                type: 'post',
                data: {
                    score: JSON.stringify(holeData)
                },
                dataType: 'json',
                success: setHoleState,
                failure: function(e)
                {
                    alert('Could not save last hole, please resubmit the result');
                }
            });

            return false;
        });

    });

</script>