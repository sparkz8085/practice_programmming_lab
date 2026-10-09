import java.util.*;

public class ascending
{
    public static void main(String args[])
    {
        int i,j,t,min;
        int num[] = new int[10];
        Scanner in = new Scanner(System.in);

        System.out.println("Enter 10 different numbers in the array:");

        for(i=0;i<10;i++)
        {
            num[i] = in.nextInt();
        }

        for(i=0;i<9;i++)
        {
            min=i;

            for(j=i+1;j<10;j++)
            {
                if(num[j]<num[min])
                    min=j;
            }

            t=num[i];
            num[i]=num[min];
            num[min]=t;
        }

        System.out.println("The numbers arranged in ascending order are: ");

        for(i=0;i<10;i++)
            System.out.println(num[i]);
    }
}
