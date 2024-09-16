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

void shuffleDeck(Card deck[]);
void dealHand(Card deck[], Card hand[]);
int evaluateHand(Card hand[]);
void printProbabilities(int handCounts[]);
unsigned long long binomialCoefficient(int n, int k);
unsigned long long countNoPair();
unsigned long long countOnePair();
unsigned long long countTwoPair();
unsigned long long countThreeOfAKind();
unsigned long long countFullHouse();
unsigned long long countFourOfAKind();
unsigned long long countFlush();
unsigned long long countStraight();
unsigned long long countStraightFlush();
unsigned long long countRoyalFlush();
void printCombinatorialProbabilities();

int main() {
    Card deck[DECK_SIZE];
    Card hand[HAND_SIZE];
    int handCounts[10] = {0}; // 0: No Pair, 1: One Pair, 2: Two Pair, 3: Three of a Kind, 4: Full House, 5: Four of a Kind, 6: Flush, 7: Straight, 8: Straight Flush, 9: Royal Flush
    
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
        if (handType >= 0 && handType < 10) {
            handCounts[handType]++;
        }
    }
    
    // Print Monte Carlo probabilities
    printProbabilities(handCounts);
    
    // Print combinatorial probabilities
    printCombinatorialProbabilities();
    
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
    int suits[4] = {0};  // Counts of each suit
    int pairs = 0, threes = 0, fours = 0;
    int isFlush = 1, isStraight = 1;
    int prevRank = -1;
    
    for (int i = 0; i < HAND_SIZE; i++) {
        ranks[hand[i].pips]++;
        suits[hand[i].suit]++;
        if (i > 0) {
            if (hand[i].pips != prevRank + 1) {
                isStraight = 0;
            }
        }
        prevRank = hand[i].pips;
    }
    
    for (int i = 1; i < 15; i++) {
        if (ranks[i] == 2) pairs++;
        else if (ranks[i] == 3) threes++;
        else if (ranks[i] == 4) fours++;
    }
    
    int isFlushHand = 0;
    for (int i = 0; i < 4; i++) {
        if (suits[i] >= 5) {
            isFlushHand = 1;
            break;
        }
    }
    
    if (fours == 1) return 5; // Four of a Kind
    if (threes == 1 && pairs == 1) return 4; // Full House
    if (threes == 1) return 3; // Three of a Kind
    if (pairs == 2) return 2; // Two Pair
    if (pairs == 1) return 1; // One Pair
    if (isFlushHand && isStraight) return 8; // Straight Flush
    if (isFlushHand) return 6; // Flush
    if (isStraight) return 7; // Straight
    return 0; // No Pair
}

void printProbabilities(int handCounts[]) {
    double totalHands = (double)NUM_HANDS;
    
    printf("Monte Carlo Hand Probabilities:\n");
    printf("No Pair: %.6f\n", handCounts[0] / totalHands);
    printf("One Pair: %.6f\n", handCounts[1] / totalHands);
    printf("Two Pair: %.6f\n", handCounts[2] / totalHands);
    printf("Three of a Kind: %.6f\n", handCounts[3] / totalHands);
    printf("Full House: %.6f\n", handCounts[4] / totalHands);
    printf("Four of a Kind: %.6f\n", handCounts[5] / totalHands);
    printf("Flush: %.6f\n", handCounts[6] / totalHands);
    printf("Straight: %.6f\n", handCounts[7] / totalHands);
    printf("Straight Flush: %.6f\n", handCounts[8] / totalHands);
    printf("Royal Flush: %.6f\n", handCounts[9] / totalHands);
}

unsigned long long binomialCoefficient(int n, int k) {
    if (k > n) return 0;
    if (k == 0 || k == n) return 1;
    k = (k > n - k) ? n - k : k;
    unsigned long long result = 1;
    for (int i = 0; i < k; ++i) {
        result = result * (n - i) / (i + 1);
    }
    return result;
}

unsigned long long countNoPair() {
    return binomialCoefficient(13, 7) * (1ULL << 7);
}

unsigned long long countOnePair() {
    return binomialCoefficient(13, 1) * binomialCoefficient(4, 2) *
           binomialCoefficient(12, 5) * (1ULL << 5);
}

unsigned long long countTwoPair() {
    return binomialCoefficient(13, 2) * binomialCoefficient(4, 2) * binomialCoefficient(4, 2) *
           binomialCoefficient(11, 3) * (1ULL << 3);
}

unsigned long long countThreeOfAKind() {
    return binomialCoefficient(13, 1) * binomialCoefficient(4, 3) *
           binomialCoefficient(12, 4) * (1ULL << 4);
}

unsigned long long countFullHouse() {
    return binomialCoefficient(13, 1) * binomialCoefficient(4, 3) *
           binomialCoefficient(12, 1) * binomialCoefficient(4, 2);
}

unsigned long long countFourOfAKind() {
    return binomialCoefficient(13, 1) * binomialCoefficient(4, 4) *
           binomialCoefficient(12, 3) * (1ULL << 3);
}

unsigned long long countFlush() {
    return binomialCoefficient(13, 5) * 4; // Choose 5 ranks and choose 1 suit from 4 suits
}

unsigned long long countStraight() {
    return binomialCoefficient(10, 1) * (1ULL << 4); // 10 possible straights (each rank as the lowest) and 4 suits per card
}

unsigned long long countStraightFlush() {
    return 10 * 4; // 10 possible straights, each in a single suit
}

unsigned long long countRoyalFlush() {
    return 4; // One royal flush per suit
}

void printCombinatorialProbabilities() {
    unsigned long long totalHands = binomialCoefficient(52, 7);
    
    printf("Combinatorial Hand Probabilities:\n");
    printf("No Pair: %.6f\n", (double)countNoPair() / totalHands);
    printf("One Pair: %.6f\n", (double)countOnePair() / totalHands);
    printf("Two Pair: %.6f\n", (double)countTwoPair() / totalHands);
    printf("Three of a Kind: %.6f\n", (double)countThreeOfAKind() / totalHands);
    printf("Full House: %.6f\n", (double)countFullHouse() / totalHands);
    printf("Four of a Kind: %.6f\n", (double)countFourOfAKind() / totalHands);
    printf("Flush: %.6f\n", (double)countFlush() / totalHands);
    printf("Straight: %.6f\n", (double)countStraight() / totalHands);
    printf("Straight Flush: %.6f\n", (double)countStraightFlush() / totalHands);
    printf("Royal Flush: %.6f\n", (double)countRoyalFlush() / totalHands);
}
