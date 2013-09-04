<?php

/**
 * Class Controller_Main
 * - main actions
 *
 * @author Filip Holmberg <filip@mafsolutions.fi>
 */
class Controller_Main extends \Fuel\Core\Controller_Template
{
    public $template = 'templates/default';

	public function action_index()
	{
        $this->template->content = View::forge('index');
	}

    public function action_group()
    {
        $players = Model_Player::get_all();

        $this->template->content = View::forge('group', array('players' => $players));
    }

    public function action_players()
    {
        $players = Model_Player::get_all();
        $this->template->content = View::forge('players', array('players' => $players));
    }

    public function action_edit_player()
    {
        if($this->param('id')) $Player = Model_Player::find($this->param('id'));
        else $Player = false;

        $this->template->content = View::forge('edit_player', array('Player' => $Player));
    }

    public function action_leaderboard()
    {
        $leaderboard = Model_Score::get_leaderboard();
        $this->template->content = View::forge('leaderboard', array('leaderboard' => $leaderboard));
    }

    public function action_scorecard()
    {
        $this->template->content = View::forge('scorecard');
    }

	public function action_404()
	{
        $this->template->content    = \Fuel\Core\View::forge('main/404');
	}
}
