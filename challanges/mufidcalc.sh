#!/bin/bash
# mufidcalc.sh - Kalkulator sederhana dengan tantangan flag tersembunyi

if [ $# != 3 ]
then
  echo "Read the manual using: cat man.txt"
else
    if [[ "$1" == "add" ]]; then
        echo "The Sum is: $(( $2 + $3 ))"
    elif [[ "$1" == "sub" ]]; then
        echo "The Substraction is: $(( $2 - $3 ))"
    elif [[ "$1" == "mul" ]]; then
        echo "The Product is: $(( $2 * $3 ))"
    elif [[ "$1" == "div" ]]; then
        echo "The Quotient is: $(( $2 / $3 ))"
    elif [[ "$1" == "showflag" ]]; then
        if [[ "$2" == "admin" && "$3" == "1337" ]]; then
            cat flag.txt
        else
            echo "Access Denied."
        fi
    else
        echo "Unknown command. Read the manual."
    fi
fi
