<?php
use Orm\Model;

class Model_Category extends Model
{
    protected static $_properties = array(
        'id',
        'name'
    );

    protected static $_has_many = array('holes');

    public function get_key_holes()
    {
        $sql = "
            SELECT MIN(num) as 'firsthole', MAX(num) as 'lasthole'
            FROM holes
            WHERE category_id = ".$this->id;

        $holes = \Fuel\Core\DB::query($sql)
            ->execute()
            ->as_array();

        $result['firstHole']    = $holes [0]['firsthole'];
        $result['lastHole']     = $holes [0]['lasthole'];

        return $result;
    }

}
