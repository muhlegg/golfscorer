<?
use Fuel\Core\Input;

class Controller_Api extends \Fuel\Core\Controller_Rest
{
    public $rest_format = 'json';

    public function get_hole()
    {
        try
        {
            $group      = Input::get('group');
            $categoryID = Input::get('category');
            $holeID     = Input::get('hole');

            // fetch first hole of category if not provided
            if(!($holeID > 0))
            {
                if(!$categoryID) throw new Exception('Critical data missing: category_id');

                $Hole = Model_Hole::get_first_by_category($categoryID);

                $holeID = $Hole->id;
            }

            $result = $this->get_hole_data($holeID, $group);

            return $this->response($result, 200);
        }
        catch(Exception $e)
        {
            return $this->response($e->getMessage(), 400);
        }
    }

    private function get_hole_data($holeID, $group)
    {
        try
        {
            $Hole = Model_Hole::find($holeID);

            $Category   = Model_Category::find($Hole->category_id);
            $keyHoles   = $Category->get_key_holes();

            $result = array();

            if($Hole->num == $keyHoles['firstHole']) $result['firstHole']   = 1;
            else $result['firstHole'] = 0;

            if($Hole->num == $keyHoles['lastHole']) $result['lastHole']    = 1;
            else $result['lastHole']   = 0;

            foreach($group as $playerID)
            {
                $Player = Model_Player::find($playerID);
                $Player->get_total_score();

                $Score = Model_Score::find(array($playerID, $holeID));
                if($Score) $Player->score = $Score->score;

                $Player->hcp = $Hole->get_hcp_placeholder($Player->slope);

                $result['players'][] = $Player;
            }

            $result['hole']  = $Hole;

            return $result;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function post_player()
    {
        try
        {
            if(!Input::post('firstname') || !Input::post('lastname') || !Input::post('slope')) throw new Exception('Missing mandatory data');

            if(Input::post('playerID'))
            {
                $Player = Model_Player::find(Input::post('playerID'));
                if(!$Player) throw new Exception('Critical error');

                $msg = 'Player updated!';
            }
            else
            {
                $Player = new Model_Player();

                $msg = 'Player created!';
            }

            $Player->firstname  = trim(Input::post('firstname'));
            $Player->lastname   = trim(Input::post('lastname'));
            $Player->slope      = trim(Input::post('slope'));
            $Player->save();

            return $this->response($msg, 200);
        }
        catch(Exception $e)
        {
            return $this->response($e->getMessage(), 400);
        }
    }

    public function post_hole()
    {
        try
        {
            $input = json_decode(Input::post('score'));


            $Hole = Model_Hole::find($input[0]->hole_id);

            $group = array();

            foreach($input as $sc)
            {
                if($sc->score > 0)
                {
                    $Player = Model_Player::find($sc->player_id);

                    $Existing = Model_Score::find(array($sc->player_id, $sc->hole_id));
                    if($Existing)
                    {
                        $Existing->score = $sc->score;
                        $Existing->set_hcp($Player->slope);
                        $Existing->save();

                        $Score = $Existing;
                    }
                    else
                    {
                        $Score              = new Model_Score();
                        $Score->player_id   = $sc->player_id;
                        $Score->hole_id     = $sc->hole_id;
                        $Score->score       = $sc->score;
                        $Score->set_hcp($Player->slope);
                        $Score->save();
                    }
                }
                $group[] = $sc->player_id;
            }

            $NextHole = $Hole->get_next();

            $result = $this->get_hole_data($NextHole->id, $group);

            return $this->response($result, 200);
        }
        catch(Exception $e)
        {
            return $this->response($e->getMessage(), 400);
        }
    }

}