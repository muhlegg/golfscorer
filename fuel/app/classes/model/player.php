<?php
use Orm\Model;

class Model_Player extends Model
{
	protected static $_properties = array(
		'id',
        'firstname',
        'lastname',
		'slope'
	);

    protected static $_has_many = array('scores');

    public static function get_all()
    {
        $players = Model_Player::query()
            ->order_by('lastname', 'ASC')
            ->get();

        return $players ? $players : false;
    }

    public function get_total_score()
    {
        $query =
            "
            SELECT
                sum(s.hcp) AS total,
                sum(s.score) AS scr,
                count(h.id) AS played
            FROM players p
                LEFT JOIN scores s ON (s.player_id = p.id)
                LEFT JOIN holes h ON (s.hole_id = h.id)
            WHERE p.id = ".$this->id;

        $total = \Fuel\Core\DB::query($query)->execute()->as_array();

        $this->total_score  = $total[0]['total'];
        $this->scr          = $total[0]['scr'];
        $this->holes_played = $total[0]['played'];
    }

    public function get_total_score2()
    {
        $total = \Fuel\Core\DB::query('select * from leaderboard where id = '.$this->id)->execute()->as_array();

        $this->total_score  = $total[0]['total'];
        $this->scr          = $total[0]['scr'];
        $this->holes_played = $total[0]['played'];
    }

}
