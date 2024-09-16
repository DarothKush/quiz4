#include <stdio.h>
#include <stdlib.h>
#include <time.h>

#define DECK_SIZE 52
#define HAND_SIZE 7
#define NUM_HANDS 1000000

typedef enum {
    HEARTS,
    DIAMONDS,
    CLUBS,
    SPADES
} Suit;

typedef struct {
    Suit suit;
    short pips;
} Card;

// Function prototypes
void shuffleDeck(Card deck[]);
void dealHand(Card deck[], Card hand[]);
int evaluateHand(Card hand[]);
void printProbabilities(int handCounts[]);

int main() {
    Card deck[DECK_SIZE];
    Card hand[HAND_SIZE];
    int handCounts[6] = {0}; // 0: No Pair, 1: One Pair, 2: Two Pair, 3: Three of a Kind, 4: Full House, 5: Four of a Kind
    
    // Initialize the deck
    for (int i = 0; i < DECK_SIZE; i++) {
        deck[i].suit = i / 13;
        deck[i].pips = i % 13 + 1;
    }
    
    srand(time(NULL)); // Seed the random number generator
    
    // Monte Carlo simulation
    for (int i = 0; i < NUM_HANDS; i++) {
        shuffleDeck(deck);
        dealHand(deck, hand);
        int handType = evaluateHand(hand);
        if (handType >= 0 && handType < 6) {
            handCounts[handType]++;
        }
    }
    
    // Print probabilities
    printProbabilities(handCounts);
    
    return 0;
}

void shuffleDeck(Card deck[]) {
    for (int i = 0; i < DECK_SIZE; i++) {
        int r = i + rand() / (RAND_MAX / (DECK_SIZE - i) + 1);
        Card temp = deck[i];
        deck[i] = deck[r];
        deck[r] = temp;
    }
}

void dealHand(Card deck[], Card hand[]) {
    for (int i = 0; i < HAND_SIZE; i++) {
        hand[i] = deck[i];
    }
}

int evaluateHand(Card hand[]) {
    int ranks[15] = {0}; // Counts of each rank
    int pairs = 0, threes = 0, fours = 0;
    
    for (int i = 0; i < HAND_SIZE; i++) {
        ranks[hand[i].pips]++;
    }
    
    for (int i = 1; i < 15; i++) {
        if (ranks[i] == 2) pairs++;
        else if (ranks[i] == 3) threes++;
        else if (ranks[i] == 4) fours++;
    }
    
    if (fours == 1) return 5; // Four of a Kind
    if (threes == 1 && pairs == 1) return 4; // Full House
    if (threes == 1) return 3; // Three of a Kind
    if (pairs == 2) return 2; // Two Pair
    if (pairs == 1) return 1; // One Pair
    return 0; // No Pair
}

void printProbabilities(int handCounts[]) {
    double totalHands = (double)NUM_HANDS;
    
    printf("Hand Probabilities:\n");
    printf("No Pair: %.6f\n", handCounts[0] / totalHands);
    printf("One Pair: %.6f\n", handCounts[1] / totalHands);
    printf("Two Pair: %.6f\n", handCounts[2] / totalHands);
    printf("Three of a Kind: %.6f\n", handCounts[3] / totalHands);
    printf("Full House: %.6f\n", handCounts[4] / totalHands);
    printf("Four of a Kind: %.6f\n", handCounts[5] / totalHands);
}