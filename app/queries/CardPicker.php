<?php

namespace App;

use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;

class CardPicker
{

    protected $AVAILABLE_GAMES = ['views.game.play.games.memory', 'views.game.play.games.questions', 'views.game.play.games.zop'];

    public function pickCard($query, $input)
    {
        $ownedAllies = new \StdClass();
        $allAllies = new \StdClass();
        $ownedResources = new \StdClass();
        $allResources = new \StdClass();
        $ownedCompetences = new \StdClass();
        $allCompetences = new \StdClass();

        $notOwned = [];

        $ownedAllies = UserItem::select('item_id')->where('user_id', $input->user_id)->where('item', 'allie')->get();
        $allAllies = Allie::select('id', 'name', 'image')->get();

        $ownedResources = UserItem::select('item_id')->where('user_id', $input->user_id)->where('item', 'resource')->get();
        $allResources = Resource::select('id', 'name', 'image')->get();

        $ownedCompetences = UserItem::select('item_id', 'level')->where('user_id', $input->user_id)->where('item', 'competence')->get();

        $user = User::find($input->user_id);
        $allCompetences = Competence::select('id', 'name', 'image', 'max_level')->whereHas('sectorCompetences', function ($query) use ($user) {
            $query->where('sector_id', $user->sector_id);
        })->get();

        foreach ($allAllies as $item) {
            if (!ModelHelper::containsItem($ownedAllies, $item->id)) {
                $item->type = "allie";
                $notOwned[] = $item;
            }
        }

        foreach ($allResources as $item) {
            if (!ModelHelper::containsItem($ownedResources, $item->id)) {
                $item->type = "resource";
                $notOwned[] = $item;
            }
        }

        foreach ($allCompetences as $item) {
            if ($item->max_level > $ownedCompetences->where('item_id', $item->id)->first()->level) {
                $item->type = "competence";
                $notOwned[] = $item;
            }
        }

        $items = new \StdClass();
        $items->cards = [];

        if (count($notOwned) > 2) {
            for ($i=0; $i<2; $i++) {
                $items->cards[] = $this->getRandomItemAndRemove($notOwned);
            }
        } else {
            $items->cards = $notOwned;
        }

        $available_games = $this->AVAILABLE_GAMES;
        
        $items->games = [];
        
        $items->games[] = $this->getRandomItemAndRemove($available_games);
        $items->games[] = $this->getRandomItemAndRemove($available_games);
 
        return $items;
    }

    public function getRandomItemAndRemove(& $notOwned)
    {
        $random = array_rand($notOwned);
        $result = $notOwned[$random];
        array_splice($notOwned, $random, 1);
        return $result;
    }
}
