#!/bin/bash
sleep 40
while true; do
    nvim --headless --listen 0.0.0.0:6666
    exit_code=$?

    # If the exit code is non-zero, break the loop
    if [ $exit_code -ne 0 ]; then
        echo "SSH command exited with a non-zero status: $exit_code"
        break
    fi

    sleep 1
done
