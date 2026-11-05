import java.util.*;
public class happy_no
{
    public static void main(String args[]) 
    {
        int temp, num, sum, val;
        Scanner sc=new Scanner(System.in);
        System.out.print("Enter a number : ");
        num = sc.nextInt();
        temp = num;
        while (num > 9) 
        {
            val = num;
            sum = 0;
            while (val != 0) 
            {
                sum=sum+(val%10);
                val=val/10;
            }
            num=sum;
        }
        if (num==1) 
        {
            System.out.printf(temp+" is a Happy Number ");
        } else {
            System.out.printf(temp+"is not a Happy Number ");
        }
    }
}
