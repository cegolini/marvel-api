<?php
/**
 * CharactersView
 *
 * @author guilhermecegolini@gmail.com
 */
class CharactersView extends TPage
{
    private $html;
    private $marvel_api_service;
    private static $array_charcters_id  = [1016181, 1009629, 1009718];

    public function __construct()
    {
        parent::__construct();

        $this->marvel_api_service = new MarvelApiService();

        // Carrega um arquivo html
        $this->html = new THtmlRenderer('app/resources/marvel-api/html/characters-view.html');
        $this->html->enableSection('main');
        // Substitui as variaveis no arquivo com os valores de um array
        $characters = $this->loadCharacters();
        $this->html->enableSection('main', array('characters' => $characters));

        parent::add($this->html);
    }

    /**
     * Buscas alguns dados de um heroi
     *
     * @author guilhermecegolini@gmail.com
     * @return [array]      um arrray contendo os dados formatados do heroi
     */
    public function loadCharacters()
    {
        $array_replaces = array();
        foreach(self::$array_charcters_id as $character_id)
        {
            $character = $this->marvel_api_service->getCharacters($character_id);

            if(empty($character))
            {
                continue;
            }

            $replace_character                = array();
            $replace_character['id']          = $character->id;
            $replace_character['name']        = $character->name;
            $replace_character['description'] = $character->description;
            $replace_character['thumbnail']   = $character->thumbnail->path . '.' .$character->thumbnail->extension;
            $replace_character['comics']      = $this->getComicsByCharacter($character_id);

            $array_replaces[] = $replace_character;
        }
        return $array_replaces;
    }

    /**
     * Buscas os dados de uma historia de um determinado heroi
     * @param character_id      string      id do heroi
     *
     * @author guilhermecegolini@gmail.com
     * @return [array]      um arrry contendo os dados formatados de uma historia
     */
    public function getComicsByCharacter($character_id)
    {
        $comics = $this->marvel_api_service->getCharactersStories($character_id, 5);

        $array_replaces = array();
        foreach ($comics as $comic)
        {
            $replace_comic                = array();
            $replace_comic['id']          = $comic->id;
            $replace_comic['title']       = $comic->title;
            $replace_comic['thumbnail']   = $comic->thumbnail->path . '.' .$comic->thumbnail->extension;

            $array_replaces[] = $replace_comic;
        }

        return $array_replaces;
    }

}