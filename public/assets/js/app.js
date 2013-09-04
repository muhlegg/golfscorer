
// restore app state
if( !document.referrer &&
    localStorage.getItem('appState') &&
    document.URL != localStorage.getItem('appState') )
{
    location.href = localStorage.getItem('appState');
}

$(function()
{

    localStorage.setItem('appState', document.URL);

    // fake backbutton
    $('#backButton').on('click', function()
    {
        if($.trim($(this).attr('href')) == '#' && document.referrer)
        {
            location.href = document.referrer;
            return false;
        }
    });

    $(document).ajaxStart(function() {
        loader('on');
    });

    $(document).ajaxStop(function() {
        loader('off');
    });

    $(document).ajaxError( function(e, xhr, options)
    {
        appError(e, xhr, options);
    });

    $('a').on('click', function() {
        loader('on');
    });

});

var loader = function(state)
{
    var $loader         = $('#loader');
    var $siteWrapper    = $('#siteWrapper');

    switch(state)
    {
        case 'on':
            $loader.fadeIn(100);
            $siteWrapper.css('opacity', 0.3);
            break;
        case 'off':
            $loader.fadeOut(100);
            $siteWrapper.css('opacity', 1);
            break;
    }
};

var appError = function(e, xhr, options)
{
    var error = JSON.stringify(xhr.responseText).replace(/"/g, '');

    alert(error);
};

var setHoleState = function(data, status)
{
    var $prevButton = $('#prevHoleButton');
    var $nextButton = $('#nextHoleButton');

    if(data.firstHole) $prevButton.hide();
    else $prevButton.fadeIn();

    $('#holeNumber').text(data.hole.num);
    $prevButton.find('.val').text(parseInt(data.hole.num) - 1);
    $nextButton.find('.val').text(parseInt(data.hole.num) + 1);

    if(data.hole.par) $('#holePar').text('par: '+data.hole.par);
    if(data.hole.hcp) $('#holeHcp').text('/ hcp: '+data.hole.hcp);

    localStorage.setItem('activeHole', data.hole.id);

    $.each(data.players, function(i)
    {
        var $existing = $('#player_'+this.id);
        var $li = false;

        if($existing.length) // existing
        {
            $li = $existing;

        }
        else // new
        {
            $li = $('#scoreTemplate').clone();

            $li .removeAttr('id')
                .attr('id', 'player_'+this.id);

            $li .data('player-id', this.id)
                .find('.name').text(this.firstname+' '+ this.lastname).end();

            $('#scoreInput').append($li);
        }

        if(this.score) $li.find('.result').val(this.score);
        else
        {
            $li .find('.result').val('').end()
                .find('input').attr('placeholder', this.hcp);
        }

        if(this.total_score) $li.find('.total').text(this.total_score);
        else $li.find('.total').text('0');

    });
};

(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")
