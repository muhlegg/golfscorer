<?php
use Orm\Model;

class Model_Score extends Model
{
    protected static $_primary_key = array('player_id', 'hole_id');

    protected static $_properties = array(
        'player_id',
        'hole_id',
        'score',
        'hcp'
    );

    protected static $_belongs_to = array('hole');

    public static function get_by_hole($holeID)
    {
        $scores = Model_Score::query()
            ->where('hole_id', $holeID)
            ->get();

        return $scores ? $scores : false;
    }

    public static function get_leaderboard()
    {
        $leaderboard = \Fuel\Core\DB::query(
            "
            SELECT
                p.id AS id,
                p.firstname AS firstname,
                p.lastname AS lastname,
                sum(s.hcp) AS total,
                sum(s.score) AS scr,
                count(h.id) AS played,
                p.slope AS slope
            FROM ( ( players p
			  LEFT JOIN scores s ON ((s.player_id = p.id)))
		      LEFT JOIN holes h ON ((s.hole_id = h.id))
	        )
            GROUP BY
                p.id
            ORDER BY
                sum(s.hcp), sum(s.score)
            ")
            ->execute()
            ->as_array();

        return $leaderboard;
    }

    public function set_hcp($playerSlope)
    {
        $this->hcp = $this->score;

        if($this->hole->hcp)
        {
            while($playerSlope >= $this->hole->hcp)
            {
                $this->hcp--;
                $playerSlope -= 18;
            }
        }
    }

}
