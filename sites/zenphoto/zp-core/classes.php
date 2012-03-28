<?php
/**
 * root object class
 * @package classes
 */

// force UTF-8 Ø

// classes.php - HEADERS STILL NOT SENT! Do not output text from this file.

// Load the authentication functions and UTF-8 Library.
require_once(dirname(__FILE__).'/auth_zp.php');

/*******************************************************************************
 *******************************************************************************
 * Persistent Object Class *****************************************************
 *
 * Parent ABSTRACT class of all persistent objects. This class should not be
 * instantiated, only used for subclasses. This cannot be enforced, but please
 * follow it!
 *
 * Documentation/Instructions:
 * A child class should run the follwing in its constructor:
 *
 * $new = parent::PersistentObject('tablename',
 *   array('uniquestring'=>$value, 'uniqueid'=>$uniqueid));
 *
 * where 'tablename' is the name of the database table to use for this object
 * type, and array('uniquestring'=>$value, ...) defines a unique set of columns
 * (keys) and their current values which uniquely identifies a single record in
 * that database table for this object. The return value of the constructor
 * (stored in $new in the above example) will be (=== TRUE) if a new record was
 * created, and (=== FALSE) if an existing record was updated. This can then be
 * used to set() default values for NEW objects and save() them.
 *
 * Note: This is a persistable model that does not save automatically. You MUST
 * call $this->save(); explicitly to persist the data in child classes.
 *
 *******************************************************************************
 ******************************************************************************/

// The query cache
$_zp_object_cache = array();
$_zp_object_update_cache = array();


// ABSTRACT
class PersistentObject {

	var $data;
	var $updates;
	var $loaded = false;
	var $table;
	var $unique_set;
	var $cache_by;
	var $id;
	var $use_cache = false;
	var $transient;

	function PersistentObject($tablename, $unique_set, $cache_by=NULL, $use_cache=true, $is_transient=false) {
		// Initialize the variables.
		// Load the data into the data array using $this->load()
		$this->data = array();
		$this->tempdata = array();
		$this->updates = array();
		$this->loaded = false;
		$this->table = $tablename;
		$this->unique_set = $unique_set;
		$this->cache_by = $cache_by;
		$this->use_cache = $use_cache;
		$this->transient = $is_transient;

		return $this->load();
	}


	/**
 	* Caches the current set of objects defined by a variable key $cache_by.
 	* Uses a global array to store the results of a single database query,
 	* where subsequent requests for the object look for data.
 	* @return a reference to the array location where this class' cache is stored
 	*   indexed by the field $cache_by.
 	*/
	function cache($entry=NULL) {
		global $_zp_object_cache;

		if (is_null($this->cache_by)) return false;
		$classname = get_class($this);
		if (!isset($_zp_object_cache[$classname])) {
			$_zp_object_cache[$classname] = array();
		}
		$cache_set = array_diff_assoc($this->unique_set, array($this->cache_by => $this->unique_set[$this->cache_by]));

		// This must be done here; the references do not work returned by a function.
		$cache_location = &$_zp_object_cache[$classname];
		foreach($cache_set as $key => $value) {
			if (!isset($cache_location[$value])) {
				$cache_location[$value] = array();
			}
			$cache_location = &$cache_location[$value];
		}
		// Exit if this object set is already cached.
		if (!empty($cache_location)) return $cache_location;

		if (!is_null($entry)) {
			$key = $entry[$this->cache_by];
			$cache_location[$key] = $entry;
		} else {
			$sql = 'SELECT * FROM ' . prefix($this->table) . getWhereClause($cache_set);
			$result = query($sql);
			if (mysql_num_rows($result) == 0) return false;

			while ($row = mysql_fetch_assoc($result)) {
				$key = $row[$this->cache_by];
				$cache_location[$key] = $row;
			}
		}
		return $cache_location;
	}


	/**
 	* Set a variable in this object. Does not persist to the database until
 	* save() is called. So, IMPORTANT: Call save() after set() to persist.
 	* If the requested variable is not in the database, sets it in temp storage,
 	* which won't be persisted to the database.
 	*/
	function set($var, $value) {
		if (empty($var)) return false;
		if ($this->loaded && !array_key_exists($var, $this->data)) {
			$this->tempdata[$var] = $value;
		} else {
			$this->updates[$var] = $value;
		}
		return true;
	}


	/**
 	* Sets default values for new objects using the set() method.
 	* Should do nothing in the base class; subclasses should override.
 	*/
	function setDefaults() {
		return;
	}

	/**
 	* Change one or more values of the unique set assigned to this record.
 	* Checks if the record already exists first, if so returns false.
 	* If successful returns true and changes $this->unique_set
 	* A call to move is instant, it does not require a save() following it.
 	*/
	function move($new_unique_set) {
		// Check if we have a row
		$result = query('SELECT * FROM ' . prefix($this->table) .
			getWhereClause($new_unique_set) . ' LIMIT 1;');
		if (mysql_num_rows($result) == 0) {
			$sql = 'UPDATE ' . prefix($this->table)
				. getSetClause($new_unique_set) . ' '
				. getWhereClause($this->unique_set);
			$result = query($sql);
			if (mysql_affected_rows() == 1) {
				$this->unique_set = $new_unique_set;
				return true;
			}
		}
		return false;
	}

	/**
	 * Copy this record to another unique set. Checks if the record exists there
	 * first, if so returns false. If successful returns true. No changes are made
	 * to this object and no other objects are created, just the database entry.
	 * A call to copy is instant, it does not require a save() following it.
	 */
	function copy($new_unique_set) {
		// Check if we have a row
		$result = query('SELECT * FROM ' . prefix($this->table) .
			getWhereClause($new_unique_set) . ' LIMIT 1;');
		if (mysql_num_rows($result) == 0) {
			// Note: It's important for $new_unique_set to come last, as its values should override.
			$insert_data = array_merge($this->data, $this->updates, $this->tempdata, $new_unique_set);
			unset($insert_data['id']);
			if (empty($insert_data)) { return true; }
			$sql = 'INSERT INTO ' . prefix($this->table) . ' (';
			$i = 0;
			foreach(array_keys($insert_data) as $col) {
				if ($i > 0) $sql .= ", ";
				$sql .= "`$col`";
				$i++;
			}
			$sql .= ') VALUES (';
			$i = 0;
			foreach(array_values($insert_data) as $value) {
				if ($i > 0) $sql .= ', ';
				if ($value == '') {
					$sql .= 'NULL';
				} else {
					$sql .= "'" . mysql_real_escape_string($value) . "'";
				}
				$i++;
			}
			$sql .= ');';
			$success = query($sql);
			if ($success == true && mysql_affected_rows() == 1) {
				return true;
			}
		}
		return false;
	}

	/**
 	* TODO: Remove this entry from the database permanently.
 	*/
	function remove() {
		return false;
	}

	/**
 	* Get the value of a variable. If $current is false, return the value
 	* as of the last save of this object.
 	*/
	function get($var, $current=true) {
		if ($current && isset($this->updates[$var])) {
			return $this->updates[$var];
		} else if (isset($this->data[$var])) {
			return $this->data[$var];
		} else if (isset($this->tempdata[$var])) {
			return $this->tempdata[$var];
		} else {
			return null;
		}
	}

	/**
 	* Load the data array from the database, using the unique id set to get the unique record.
 	* @return false if the record already exists, true if a new record was created.
 	*/
	function load() {
		$new = false;
		$entry = null;
		// Set up the SQL query in case we need it...
		$sql = 'SELECT * FROM ' . prefix($this->table) . getWhereClause($this->unique_set) . ' LIMIT 1;';
		// But first, try the cache.
		if ($this->use_cache) {
			$reporting = error_reporting(0);  // TODO: fix the following code. It is flagged by E_STRICT error reporting
			$cache_location = &$this->cache();
			$entry = &$cache_location[$this->unique_set[$this->cache_by]];
			error_reporting($reporting);
			
		}
		// Re-check the database if: 1) not using cache, or 2) didn't get a hit.
		if (empty($entry)) {
			$entry = query_single_row($sql);
		}

		// If we don't have an entry yet, this is a new record. Create it.
		if (empty($entry)) {
			if ($this->transient) { // no don't save it in the DB!
				$entry = array_merge($this->unique_set, $this->updates, $this->tempdata);
				$entry['id'] = '';
			} else {
				$new = true;
				$this->save();
				$entry = query_single_row($sql);
				// If we still don't have an entry, something went wrong...
				if (!$entry) return null;
				// Then save this new entry into the cache so we get a hit next time.
				$this->cache($entry);
			}
		}
		$this->data = $entry;
		$this->id = $entry['id'];
		$this->loaded = true;
		return $new;
	}

	/**
 	* Save the updates made to this object since the last update. Returns
 	* true if successful, false if not.
 	*/
	function save() {
		if (!$this->unique_set) return; // If we don't have a unique set, then this is incorrect. Don't attempt to save.
		if ($this->transient) return; // If this object isn't supposed to be persisted, don't save it.
		if ($this->id == null) {
			$this->setDefaults();
			// Create a new object and set the id from the one returned.
			$insert_data = array_merge($this->unique_set, $this->updates, $this->tempdata);
			if (empty($insert_data)) { return true; }
			$sql = 'INSERT INTO ' . prefix($this->table) . ' (';
			$i = 0;
			foreach(array_keys($insert_data) as $col) {
				if ($i > 0) $sql .= ", ";
				$sql .= "`$col`";
				$i++;
			}
			$sql .= ') VALUES (';
			$i = 0;
			foreach(array_values($insert_data) as $value) {
				if ($i > 0) $sql .= ', ';
				if (is_null($value)) {
					$sql .= "NULL";
				} else {
					$sql .= "'". mysql_real_escape_string($value) . "'";
				}
				$i++;
			}
			$sql .= ');';
			$success = query($sql);
			if ($success == false || mysql_affected_rows() != 1) { return false; }
			$this->id = mysql_insert_id();
			$this->updates = array();
			$this->tempdata = array();

		} else {
			// Save the existing object (updates only) based on the existing id.
			if (empty($this->updates)) {
				return true;
			} else {
				$sql = 'UPDATE ' . prefix($this->table) . ' SET';
				$i = 0;
				foreach ($this->updates as $col => $value) {
					if ($i > 0) $sql .= ",";
					if (is_null($value)) {
						$sql .= " `$col` = NULL";
					} else {
						$sql .= " `$col` = '". mysql_real_escape_string($value) . "'";
					}
					$this->data[$col] = $value;
					$i++;
				}
				$sql .= ' WHERE id=' . $this->id . ';';
				$success = query($sql);
				if ($success == false || mysql_affected_rows() != 1) { return false; }
				$this->updates = array();
			}
		}
		return true;
	}

}
?>
