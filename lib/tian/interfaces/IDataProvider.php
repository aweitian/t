<?php
interface IDataProvider {
	function getId();
	function getItemCount();
	function getTotalItemCount();
	function getData();
	function getKeys();
	function getSort();
	function getPagination();
}

?>