<br/>
<br/>

<a id="scorecardButton" href="/scorecard" class="button"><i class="icon-doc-text"></i> Scorecard</a>

<a href="/leaderboard" class="button"><i class="icon-award"></i> Leaderboard</a>

<a href="/group" class="button"><i class="icon-users"></i> Create group</a>

<a href="/players" class="button"><i class="icon-user"></i> Players</a>

<script>

    $(function()
    {
        if(!localStorage.getItem('activeGroup'))
        {
            $('#scorecardButton').hide();
        }

    });

</script>