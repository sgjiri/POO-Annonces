<?php

namespace App\Models;

use App\DB\Db;


class Model extends Db
{
    //Table de la base de données 
    protected $table;
    //Instance de DB Cette erreur je t'envoie mes fichiers. 
    private $db;

    /**
     * Undocumented function
     *
     * @return void
     */
    public function findAll()
    {
        $query = $this->runQuery("SELECT * FROM " . $this->table);
        return $query->fetchAll();
    }

    /**
     * Undocumented function
     *
     * @param array $criters
     * @return void
     */
    public function findBy(array $criters)
    {
        $champs = [];
        $valeurs = [];

        //En boucle pour éclater le tableau 
        foreach ($criters as $champ => $valeur) {
            //SELECT * FROMM annonces WHERE actif =?
            //bindParame(1, valeur)

            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;

            //On transforme le tableau champs en chaîne de caractères. 
            $liste_champs = implode(" AND ", $champs);
            return $this->runQuery("SELECT * FROM " . $this->table . " WHERE " . $liste_champs, $valeurs)->fetchAll();
            //SELECT * FROM table_name WHERE actif = ? AND categorie = ? AND prix = ?

        }
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return void
     */
    public function find(int $id)
    {
        return $this->runQuery("SELECT*FROM $this->table WHERE id = $id")->fetch();
    }

    /**
     * Undocumented function
     *
     * @param Model $model
     * @return void
     */
    public function create(Model $model)
    {
        $champs = [];
        $inter = [];
        $valeurs = [];
        //En boucle pour éclater le tableau 
        foreach ($model as $champ => $valeur) {
            //INSERT INTO annonces (titre, description, actif) values(?,?,?)
            //bindParame(1, valeur)
            if ($valeur != null && $champ != "db" && $champ != "table") {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        //On transforme le tableau champs en chaîne de caractères. 

        $liste_champs = implode(" , ", $champs);
        $liste_inter = implode(" , ", $inter);
        $sql = "INSERT INTO " . $this->table . " (" . $liste_champs . ") VALUES (" . $liste_inter . ")";

        return $this->runQuery("INSERT INTO " . $this->table . " (" . $liste_champs . ") VALUES (" . $liste_inter . ")", $valeurs);
        //SELECT * FROM table_name WHERE actif = ? AND categorie = ? AND prix = ?


    }

    /**
     * Undocumented function
     *
     * @param Model $model
     * @return void
     */
    public function update(int $id, Model $model)
    {
        $champs = [];
        $valeurs = [];
        //En boucle pour éclater le tableau 
        foreach ($model as $champ => $valeur) {
            //UPDATE annonces SET titre=?, description=?, actif=? WHERE id = ?
            if ($valeur !== null && $champ != "db" && $champ != "table") {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }

        $valeurs[] = $id;

        //On transforme le tableau champs en chaîne de caractères. 

        $liste_champs = implode(" , ", $champs);
        return $this->runQuery("UPDATE " . $this->table . " SET " . $liste_champs . "WHERE id = ?", $valeurs);
        //SELECT * FROM table_name WHERE actif = ? AND categorie = ? AND prix = ?


    }

    public function delete(int $id)
    {
        return $this->runQuery("DELETE FROM $this->table WHERE id=?", [$id]);
    }

    /**
     * Undocumented function
     *
     * @param string $sql
     * @param array|null $attributs
     * @return object
     */
    public function runQuery(string $sql, array $attributs = null)
    {
        //On récupère l'instance de DB 
        $this->db = Db::getInstace();

        //On vérifie si on a des attributs. 
        if ($attributs !== null) {
            //Requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            //Requete simple. 
            return $this->db->query($sql);
        }
    }

    /**
     * Undocumented function
     *
     * @param array $donnees
     * @return Model
     */
    public function hydrate(array $donnees)
    {
        foreach($donnees as $key => $value){
            //On récupère le nom du setteur correspondant à la clé (key)
            //titre-> setTitre
            $setter = "set".ucfirst($key);

            //On verifie, c'est le setteur existe. 
            if(method_exists($this, $setter)){
                //On appel le setteur 
                $this->$setter($value);
            }
        }
        return $this;
    }
}
