<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Incidentes
{
	private $db;
	private $recordsByPage = 5;

	/*
	 *
	 */
	public function __construct($container)
	{
		$this->db = $container->get('db');
	}

	/*
	 *
	 */
	public function getIncidentesPorPagina(Request $request, Response $response, $args)
	{
		$page = $args['pagina'];

		$startFrom = (($page -1) * $this->recordsByPage);

		$pstmt = $this->db->prepare('SELECT * FROM incidentes');
		$pstmt->execute();

		$data['total'] = $pstmt->rowCount();

		$pstmt = $this->db->prepare('SELECT * FROM incidentes LIMIT :startFrom, :recordsByPage');
		$pstmt->bindParam('startFrom', $startFrom, \PDO::PARAM_INT);
		$pstmt->bindParam('recordsByPage', $this->recordsByPage, \PDO::PARAM_INT);
		$pstmt->execute();

		$data['data'] = $pstmt->fetchAll();

		return $response->withJson($data);
	}

	/*
	 *
	 */
	public function getIncidentes(Request $request, Response $response, $args)
	{
		$id = $args['id'];

		$pstmt = $this->db->prepare('SELECT * FROM incidentes WHERE id = :id');
		$pstmt->bindParam('id', $id, \PDO::PARAM_INT);
		$pstmt->execute();

		$data = $pstmt->fetch();

		return $response->withJson($data);
	} 

	/*
	 *
	 */
	public function addIncidentes(Request $request, Response $response, $args)
	{
		$input = $request->getParsedBody();

		$pstmt = $this->db->prepare('INSERT INTO `incidentes` (`titulo`, `descricao`, `criticidade`, `tipo`) VALUES (:titulo, :descricao, :criticidade, :tipo)');
		$pstmt->bindParam('titulo', $input['titulo']);
		$pstmt->bindParam('descricao', $input['descricao']);
		$pstmt->bindParam('criticidade', $input['criticidade']);
		$pstmt->bindParam('tipo', $input['tipo']);
		$pstmt->execute();

		$pstmt = $this->db->prepare('SELECT * FROM incidentes ORDER BY id DESC LIMIT 1');
		$pstmt->execute();

		$data['data'] = $pstmt->fetch();

		$pstmt = $this->db->prepare('SELECT * FROM incidentes');
		$pstmt->execute();

		$data['total'] = $pstmt->rowCount();

		return $response->withStatus(201)->withJson($data);
	}

	/*
	 *
	 */
	public function updateIncidentes(Request $request, Response $response, $args)
	{
		$input = $request->getParsedBody();

		$query = 'UPDATE `incidentes`
				  SET `titulo` = :titulo, `descricao` = :descricao, `criticidade` = :criticidade, `tipo` = :tipo, `status` = :status
				  WHERE `id` = :id';

		$pstmt = $this->db->prepare($query);
		$pstmt->bindParam('titulo', $input['titulo']);
		$pstmt->bindParam('descricao', $input['descricao']);
		$pstmt->bindParam('criticidade', $input['criticidade']);
		$pstmt->bindParam('tipo', $input['tipo']);
		$pstmt->bindParam('status', $input['status']);
		$pstmt->bindParam('id', $input['id'], \PDO::PARAM_INT);
		$pstmt->execute();

		$pstmt = $this->db->prepare('SELECT * FROM incidentes WHERE id = :id');
		$pstmt->bindParam('id', $input['id'], \PDO::PARAM_INT);
		$pstmt->execute();

		$data = $pstmt->fetch();

		return $response->withJson($data);
	}

	/*
	 *
	 */
	public function deleteIncidentes(Request $request, Response $response, $args)
	{
		$id = $args['id'];

		$pstmt = $this->db->prepare('DELETE FROM incidentes WHERE id = :id');
		$pstmt->bindParam('id', $id, \PDO::PARAM_INT);
		$pstmt->execute();

		$pstmt = $this->db->prepare('SELECT * FROM incidentes');
		$pstmt->execute();

		$data['total'] = $pstmt->rowCount();

		return $response->withStatus(204)->withJson($data);
	}
}