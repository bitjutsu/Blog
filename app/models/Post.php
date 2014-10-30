<?php

class Post {
    public function __construct($data) {
        # Set the default id to -1 to signal not stored.
        $this->id = -1;
        # TODO: ^this should be a private member so that the user can't override
        # and mess up the database synchronization. Maybe using __get() magic?

        # Create a new Post record with the appropriate data if it is passed:
        if (!empty($data)) {
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->body = $data['body'];
            $this->date_created = $data['date_created'];
            $this->date_modified = $data['date_modified'];
        }
    }

    private function db_operation($manipulator) {
        $db = new SQLite3(dirname(__FILE__).'/../../data/prod.sqlite');
        $result = $manipulator($db);
        $db->close();

        return $result;
    }

    private function querySingle($query) {
        return Post::db_operation(function ($db) use ($query) {
            return $db->querySingle($query, true);
        });
    }

    private function queryAll($query) {
        return Post::db_operation(function($db) use ($query) {
            $results = $db->query($query);

            if (is_null($results) || empty($results)) {
                return array();
            }

            $result = array();
            while ($data = ($results->fetchArray())) {
                array_push($result, new Post($data));
            }

            return $result;
        });
    }

    /* Do database stuff. */
    public function find($id) {
        $result = Post::querySingle("SELECT * FROM posts WHERE id=$id");

        return new Post($result);
    }

    /* Paginate by 10, starting at page 0 */
    public function all($limit = 10, $page = 0) {
        $offset = $page * $limit;
        return Post::queryAll("SELECT * FROM posts ORDER BY id DESC LIMIT $limit OFFSET $offset");
    }

    public function save() {
        # If the post doesn't have an id, it has not been entered into the database.
        $first_time = ($this->id == -1);

        if ($first_time) {
            # Insert the post into the database.
            $result = Post::querySingle(
                "INSERT INTO posts VALUES (
                    NULL,
                    {$this->title},
                    {$this->body},
                    datetime('now'),
                    datetime('now')
                )"
            );

            # Update the record with the new dates and give it an id:
            $this->date_created = $result->date_created;
            $this->date_modified = $result->date_modified;
            $this->id = $result->id;
        } else {
            # Update the existing post:
            $result = Post::querySingle(
                "UPDATE posts SET
                    title={$this->title},
                    body={$this->body},
                    date_modified=datetime('now')
                WHERE id={$this->id}"
            );

            # Update the record with the new modification date:
            $this->date_modified = $result->date_modified;
        }

        return $this;
    }

    public function destroy($id) {
        return db_operation(function ($db) use ($id) {
            return $db->query("DELETE FROM posts WHERE id=$id");
        });
    }

    public function __toString() {
        return json_encode($this);
    }
}
