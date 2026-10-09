import java.util.*;
class oddeven
{
    public static void main(String args[])
    {
        Scanner sc=new Scanner(System.in);
	System.out.println("enter the size of array: ");
	int size=sc.nextInt();
        int a[] = new int[size];
        int n, pos = -1;
        System.out.println("Entert the numbers:");
        for(int i = 0; i < size; i++)
            a[i] = sc.nextInt();
        System.out.print("Enter number to search: ");
        n = sc.nextInt();
        for(int i = 0; i < size; i++)
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
