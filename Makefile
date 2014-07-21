all: clean apidocs

apidocs:
	vendor/bin/apigen.php --source src/ --destination api/ --exclude="*/Tests/*"

clean:
	rm -rf api/*