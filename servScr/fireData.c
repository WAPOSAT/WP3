#include<stdio.h>
#include<stdlib.h>
#include<time.h>
#include<string.h>
#define MAX_SENSORS 10
#define NUM_SENDERS 4

int main(int argc, char* argv[])
{
        srand(time(NULL));
        //printf("You entered %i characters\n", argc );
        int sensor, i, j;
        int nSensorPerQuerie, nQueries = atoi(argv[1]);
        float val;
        char buf[20], str[20][100];
        const char macs[4][50] = {"abc", "def", "mno", "pqr"};
        const char tmps[4][50] = {"123", "123", "123", "123"};

        for(j=0; j<nQueries; j++)
        {
                strcpy(str[j], "monitor/");
                strcat(str[j], macs[j]);
                strcat(str[j], "|");
                strcat(str[j], tmps[j]);
                nSensorPerQuerie = 1+rand()%MAX_SENSORS;
                for(i=0; i<nSensorPerQuerie; i++)
                {
                        sensor = 1+rand()%14;
                        val = (rand()%10000)/100.0;
                        sprintf(buf, "|%i|%.2f", sensor, val);
                        //printf("%s\n", buf);
                        strcat(str[j], buf);
                }
        }

        /*for(j=0; j<nQueries; j++)
        {
                printf("result %s\n", str[j]);
        }*/

        FILE *outFile;
        outFile = fopen("out", "w");
        fprintf(outFile, "#!/bin/bash\n\n");
        for(j=0; j<nQueries; j++)
        {
                fprintf(outFile, "curl -o /var/www/html/waposatdev/wptest/servScr/temp \"http:/\/monitoreo.waposat.com/%s\"\n", str[j]);
        }
        fclose(outFile);

        printf("OKKK\n");

        return 0;


}

