# -*- coding: utf-8 -*-
#Created from scratch by Justin Leach 11/1/2020
#I know it's not the most advanced thing ever but it proves I know Python

import random #use for the robot's choices

#Function that prints the game board
def printer(table):
    print("+-----------------+")
    for i in range(len(table)): #loop through rows
        print("|  ", end="")
        for i2 in range(len(table[i])): #loop through columns in that row
            print(table[i][i2] + "  |  ", end ="")#prints columns
        print("")#new line
        print("+-----------------+")

#Function to check if a player has won
def check(table, row, col, symbol):
    #check for diagonal victories
    if table[0][0] == symbol and table[1][1] == symbol and table[2][2] == symbol: #downward diagonal victory
        result = True
    elif table[0][2] == symbol and table[1][1] == symbol and table[2][0] == symbol: #upward diagonal victory
        result = True
    #check for vertical victories
    elif table[0][0] == symbol and table[1][0] == symbol and table[2][0] == symbol: #vertical victory
        result = True
    elif table[0][1] == symbol and table[1][1] == symbol and table[2][1] == symbol: #vertical victory
        result = True   
    elif table[0][2] == symbol and table[1][2] == symbol and table[2][2] == symbol: #vertical victory
        result = True
    #check for horizontal victories
    elif table[0][0] == symbol and table[0][1] == symbol and table[0][2] == symbol: #vertical victory
        result = True
    elif table[1][0] == symbol and table[1][1] == symbol and table[1][2] == symbol: #vertical victory
        result = True   
    elif table[2][0] == symbol and table[2][1] == symbol and table[2][2] == symbol: #vertical victory
        result = True
    else:
        result = False
    return result

#Function that checks if the game is a tie
def tie(table):
    tie = True
    for i in range(len(table)): #loop through rows
        for i2 in range(len(table[i])): #loop through columns in that row
            if table[i][i2] == ' ': #test to find an empty space
                tie = False #if empty space, not a tie
    return tie

#Main function
def main():
    #initialize variables
    result = True #boolean for the check function - determines if a player has won
    col = ' ' #column initial value
    row1 = [col, col, col] #need three rows and three columns
    row2 = [col, col, col]
    row3 = [col, col, col]
    table = [row1, row2, row3] #table is a nested list
    done = False #boolean to keep the game going to the next turn
    robotdone = False #boolean to keep the robot guessing in case he picks a space already in use
    randrow = 0 #robot row
    randcol = 0 #robot column
    col, row = input('Enter coordinate (example: "2 3" for bottom middle): ').split() #give instructions
    #The entire game is contained within this loop:
    while done == False:  
        try:
            tiegame = tie(table)#first check for a tie
            if tiegame == False: #not a tie, keep playing
                row = int(row)#make sure they are integers
                col = int(col)
                row -= 1#convert them to index numbers, based on 0 instead of 1
                col -= 1
                if 0 > row or 2 < row or 0 > col or 2 < col:
                    print("Please enter numbers between 1 and 3")
                else:
                    if table[row][col] == ' ':#valid entry
                        table[row][col] = 'X'
                        printer(table) #call printer function and pass the table
                        symbol = 'X'
                        result = check(table, row, col, symbol) #call the check function, get the boolean result
                        if result == True: #You win!
                            done = True
                            print("You Win!")
                        else: #you did not win - give the robot a turn
                            tiegame = tie(table)#first check for a tie
                            if tiegame == False: #not a tie, keep playing
                                robotdone = False #make sure it is false
                                while robotdone == False:
                                    randrow = random.randint(0,2)#robot chooses a row
                                    randcol = random.randint(0,2)#robot chooses a column
                                    if table[randcol][randrow] == ' ': #valid entry
                                        robotdone = True
                                    else:
                                        robotdone = False
                                table[randcol][randrow] = 'O'
                                printer(table) #call printer function and pass the table
                                symbol = 'O'
                                result = check(table, randrow, randcol, symbol) #call the check function, get the boolean result
                                if result == True: #You lose!
                                    done = True
                                    print("You Lose!")       
                            else: #tie game
                                print("It's a tie!")
                                done = True
                    else:
                        print("Already taken!")
                #show next input if the game is not done
                if done != True:
                    col, row = input('Enter coordinate: ').split()
            else: #tie game
                print("It's a tie!")
                done = True
        except:
            print('Enter numbers between 1 and 3 in this format: "x y"')
            
main() #calls the main function to start the game
