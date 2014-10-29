all: clean apidocs

apidocs:
	vendor/bin/apigen generate api/ src/

clean:
	rm -rf api/*