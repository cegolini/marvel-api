<?php
/**
 * MarvelApiService
 *
 * classe para conexao com a api da marvel
 * @author guilhermecegolini@gmail.com
 */
class MarvelApiService
{
    private $marvel_api;

    public function __construct()
    {
        $this->marvel_api = parse_ini_file('app/config/marvel-api.ini', true);
    }

    /**
     * Buscas dados de um heroi
     *
     * @author guilhermecegolini@gmail.com
     * @return [sdtclass]      um objeto contendo os dados de um heroi
     */
    public function getCharacters($character_id)
    {
        try
        {
            $url    = "{$this->marvel_api['endpoint']}characters/{$character_id}?ts={$this->marvel_api['time']}&apikey={$this->marvel_api['public_key']}&hash={$this->getHash()}";
            $result = json_decode(file_get_contents($url));

            $data = NULL;
            if(isset($result->data->results) AND $result->data->results != NULL)
            {
                $data = array_shift($result->data->results);
            }

            return $data;
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            echo 'Ocorreu um erro por favor tente novamente';
        }
    }

    /**
     * Buscas dados de historias
     *
     * @author guilhermecegolini@gmail.com
     * @return [array]      um arrray contendo as historias
     */
    public function getCharactersStories($character_id, $limit = 5)
    {
        $url    = "{$this->marvel_api['endpoint']}characters/{$character_id}/comics?ts={$this->marvel_api['time']}&apikey={$this->marvel_api['public_key']}&hash={$this->getHash()}&limit={$limit}";
        $result = json_decode(file_get_contents($url));

        $data = NULL;
        if(isset($result->data->results) AND $result->data->results != NULL)
        {
            $data = $result->data->results;
        }

        return $data;
    }

     /**
     * Monta o hash nescessario para a conexao com api
     *
     * @author guilhermecegolini@gmail.com
     * @return [string]      hash md5
     */
    public function getHash()
    {
        return md5($this->marvel_api['time'] . $this->marvel_api['private_key'] . $this->marvel_api['public_key']);
    }

}

?>