import java.util.*;
public class array2 
{
    public static void main(String args[])
    {
        Scanner sc = new Scanner(System.in);
        System.out.println("enter the size to identify odd and even : ");
        int size = sc.nextInt();
        int arr[] = new int[size];
        for (int j = 0; j < size; j++) 
        {
            System.out.println("enter value " + (j + 1));
            arr[j] = sc.nextInt();
        }
        System.out.println("entered values...");
        for (int j = 0; j < size; j+++) 
        {
            System.out.print(arr[j] + ",");
            if (j % 2 == 0) 
            {
                System.out.println(j+" is even");
            } 
            else 
            {
                System.out.println(j+" is odd");
            }
        }
    }
}
