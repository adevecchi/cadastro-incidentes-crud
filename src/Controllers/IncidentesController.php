<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class IncidentesController
{
	private $db;

	private const RECORDS_BY_PAGE = 5;

	
	public function __construct($container)
	{
		$this->db = $container->get('db');
	}

	
	public function getIncidentesPorPagina(Request $request, Response $response, $args)
	{
		$page = $args['pagina'];

		$recordsByPage = self::RECORDS_BY_PAGE;

		$startFrom = (($page -1) * self::RECORDS_BY_PAGE);

		$pstmt = $this->db->prepare('SELECT * FROM incidentes');
		$pstmt->execute();

		$data['total'] = $pstmt->rowCount();

		$pstmt = $this->db->prepare('SELECT * FROM incidentes LIMIT :startFrom, :recordsByPage');
		$pstmt->bindParam('startFrom', $startFrom, \PDO::PARAM_INT);
		$pstmt->bindParam('recordsByPage', $recordsByPage, \PDO::PARAM_INT);
		$pstmt->execute();

		$data['data'] = $pstmt->fetchAll();

		if (!count($data['data']))
			$data['data'] = [];

		return $response->withStatus(200)->withJson($data);
	}

	
	public function getIncidentes(Request $request, Response $response, $args)
	{
		$id = $args['id'];

		$pstmt = $this->db->prepare('SELECT * FROM incidentes WHERE id = :id');
		$pstmt->bindParam('id', $id, \PDO::PARAM_INT);
		$pstmt->execute();

		$data = $pstmt->fetch();

		if ($data === false)
			$data = new \StdClass();

		return $response->withStatus(200)->withJson($data);
	} 

	
	public function addIncidentes(Request $request, Response $response, $args)
	{
		try {
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
		catch(\PDOException $e) {
			return $response->withStatus(400)->withJson(['code' => 400, 'status' => 'Bad Request']);
		}
	}

	
	public function updateIncidentes(Request $request, Response $response, $args)
	{
		try {
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

			if ($data === false) {
				$code = 404;
				$data = ['code' => 404, 'status' => 'Not Found'];
			} else {
				$code = 200;
			}

			return $response->withStatus($code)->withJson($data);
		}
		catch (\PDOException $e) {
			return $response->withStatus(400)->withJson(['code' => 400, 'status' => 'Bad Request']);
		}
	}

	
	public function deleteIncidentes(Request $request, Response $response, $args)
	{
		$id = $args['id'];

		$pstmt = $this->db->prepare('DELETE FROM incidentes WHERE id = :id');
		$pstmt->bindParam('id', $id, \PDO::PARAM_INT);
		$pstmt->execute();

		$delete = $pstmt->rowCount();

		$pstmt = $this->db->prepare('SELECT * FROM incidentes');
		$pstmt->execute();

		$data['total'] = $pstmt->rowCount();

		if (!$delete) {
			$code = 404;
			$data['code'] = $code;
			$data['status'] = 'Not Found';
		}
		else {
			$code = 200;
			$data['code'] = $code;
			$data['status'] = 'Ok';
		}
		
		return $response->withStatus($code)->withJson($data);
	}
}