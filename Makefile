.PHONY: commit push auto auto-ai

# ---------------------------------------------
# AUTO COMMIT BERDASARKAN PERUBAHAN FILE
# ---------------------------------------------
simple_commit_msg := $(shell \
    git status --porcelain | awk '{print $$2}' | paste -sd ", " - \
)

auto:
	@if [ -z "$$(git status --porcelain)" ]; then \
		echo "No changes to commit"; \
	else \
		echo "Committing (simple mode): update: $(simple_commit_msg)"; \
		git add .; \
		git commit -m "update: $(simple_commit_msg)"; \
		make push; \
	fi

# ---------------------------------------------
# AUTO COMMIT PAKAI GEMINI AI
# ---------------------------------------------
auto-ai:
	@if [ -z "$$(git status --porcelain)" ]; then \
		echo "No changes to commit"; \
	else \
		echo "Generating AI commit message..."; \
		php ai-commit.php > .ai_commit_msg; \
		if grep -q "NO_CHANGES" .ai_commit_msg; then \
			echo "No diff found"; \
		else \
			echo "AI Commit message:"; \
			cat .ai_commit_msg; \
			git add .; \
			git commit -m "$$(cat .ai_commit_msg)"; \
			make push; \
		fi \
	fi

push:
	@git push origin main
