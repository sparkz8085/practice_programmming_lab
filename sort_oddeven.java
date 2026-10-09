import java.util.*;
class sort_oddeven
{
    public static void main(String args[])
    {
        Scanner sc=new Scanner(System.in);

        int a[] = new int[20];
        int n, pos = -1;
        System.out.println("Entert the numbers:");
        for(int i = 0; i < 20; i++)
            a[i] = sc.nextInt();
        System.out.print("Enter number to search: ");
        n = sc.nextInt();
        for(int i = 0; i < 20; i++)
        {
            if(a[i] == n)
            {
                pos = i;
                break;
            }
        }
        if(pos != -1)
        {
            System.out.println("Number is present.");
            if(n % 2 == 0)
                System.out.println("It is even.");
            else
                System.out.println("It is odd.");
            if(n > 0)
                System.out.println("It is positive.");
            else if(n < 0)
                System.out.println("It is negative.");
            else
                System.out.println("It is zero.");
        }
        else
        {
            System.out.println("Number is not present.");
        }
    }
}
