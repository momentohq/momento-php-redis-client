.PHONY: install lint-check lint test-momento test-redis test-redis-docker test test-docker

install:
	@echo "Installing dependencies..."
	@composer install

lint-check:
	@echo "Checking code style..."
	@composer lint

lint:
	@echo "Fixing code style..."
	@composer lint-fix

test-momento:
	@echo "Running momento-backed tests..."
	@TEST_BACKEND="momento" composer test

test-redis:
	@echo "Running redis-backed tests..."
	@TEST_BACKEND="redis" composer test

test-redis-docker:
	@REDIS_HOST=redis make test-redis

test: test-momento test-redis

test-docker: test-momento test-redis-docker
