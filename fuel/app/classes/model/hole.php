<?php
use Orm\Model;

class Model_Hole extends Model
{
    protected static $_properties = array(
        'id',
        'category_id',
        'num',
        'par',
        'hcp'
    );

    protected static $_belongs_to = array('category');

    protected static $_has_many = array('scores');

    public static function get_first_by_category($categoryID)
    {
        $Hole = Model_Hole::query()
            ->where('category_id', $categoryID)
            ->order_by('id')
            ->get_one();

        return $Hole ? $Hole : false;
    }

    public function get_hcp_placeholder($playerSlope)
    {
        if(!$this->hcp) return '-';

        $hcpScore = 0;

        while($playerSlope >= $this->hcp)
        {
            $hcpScore--;
            $playerSlope -= 18;
        }

        return $hcpScore;
    }

    public static function get_by_num($num, $categoryID)
    {
        $Hole = Model_Hole::query()
            ->where('num', $num)
            ->where('category_id', $categoryID)
            ->get_one();

        return $Hole;
    }

    public function get_next()
    {
        return $this->get_by_num($this->num + 1, $this->category_id);
    }

}
